<?php

namespace App\Providers;

use App\Environment;
use App\Models\Directory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class SamlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Environment::shouldExecute()) {
            return;
        }

        config(['saml2_settings.idpNames' => $this->getDirectorySlugs()]);

        foreach ($this->getDirectories() as $directory) {
            config(['saml2.' . $directory['slug'] . '_idp_settings' => [
                'strict' => true,
                'debug'  => env('APP_DEBUG', false),
                'sp'     => [
                    'NameIDFormat'             => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
                    'x509cert'                 => '',
                    'privateKey'               => '',
                    'entityId'                 => '',
                    'assertionConsumerService' => [
                        'url' => '',
                    ],
                    'singleLogoutService'      => [
                        'url' => '',
                    ],
                ],
                'idp'    => [
                    'entityId'                 => $directory['saml_entity_id'],
                    'singleSignOnService'      => [
                        'url' => $directory['saml_sso_url'],
                    ],
                    'singleLogoutService'      => [
                        'url' => $directory['saml_slo_url'],
                    ],
                    'x509cert'                 => '', // We use the fingerprint instead
                    'certFingerprint'          => $directory['saml_cfi'],
                    'certFingerprintAlgorithm' => 'sha256',
                ],

                'security'      => [
                    'nameIdEncrypted'       => false,
                    'authnRequestsSigned'   => false,
                    'logoutRequestSigned'   => false,
                    'logoutResponseSigned'  => false,
                    'signMetadata'          => false,
                    'wantMessagesSigned'    => false,
                    'wantAssertionsSigned'  => false,
                    'wantNameIdEncrypted'   => false,
                    'requestedAuthnContext' => true,
                ],
                'contactPerson' => [
                    'technical' => [
                        'givenName'    => $directory['saml_contact_name'],
                        'emailAddress' => $directory['saml_contact_email'],
                    ],
                    'support'   => [
                        'givenName'    => $directory['saml_contact_name'],
                        'emailAddress' => $directory['saml_contact_email'],
                    ],
                ],
                'organization'  => [
                    'en-US' => [
                        'name'        => strtolower($directory['saml_organization_name']),
                        'displayname' => $directory['saml_organization_name'],
                        'url'         => $directory['saml_website_url'],
                    ],
                ],
            ]]);
        }
    }

    /**
     * @return array
     */
    protected function getDirectorySlugs()
    {
        $cacheKey = 'directory_slugs_list';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        } else {
            $directorySlugs = Directory::pluck('slug')->toArray();
            Cache::forever($cacheKey, $directorySlugs);

            return $directorySlugs;
        }
    }

    /**
     * @return array
     */
    protected function getDirectories()
    {
        $cacheKey = 'directory_settings';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        } else {
            $directories = Directory::all()->toArray();
            Cache::forever($cacheKey, $directories);

            return $directories;
        }
    }
}
