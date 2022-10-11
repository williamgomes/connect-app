<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * The model for the Directory entity.
 */
class Directory extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'onelogin_tenant_url',
        'onelogin_api_url',
        'onelogin_client_id',
        'onelogin_secret_key',
        'onelogin_default_role',
        'duo_integration_key',
        'duo_secret_key',
        'duo_api_url',
        'saml_entity_id',
        'saml_sso_url',
        'saml_slo_url',
        'saml_cfi',
        'saml_contact_name',
        'saml_contact_email',
        'saml_organization_name',
        'saml_website_url',
    ];

    protected static $createRules = [
        'name'                   => 'required|string|unique:directories,name',
        'slug'                   => 'required|regex:/^[a-z0-9-]+$/|unique:directories,slug',
        'onelogin_tenant_url'    => 'sometimes|nullable|url',
        'onelogin_api_url'       => 'sometimes|nullable|url',
        'onelogin_client_id'     => 'sometimes|nullable|string',
        'onelogin_secret_key'    => 'sometimes|nullable|string',
        'onelogin_default_role'  => 'sometimes|nullable|integer',
        'duo_integration_key'    => 'sometimes|nullable|string',
        'duo_secret_key'         => 'sometimes|nullable|string',
        'duo_api_url'            => 'sometimes|nullable|string',
        'saml_entity_id'         => 'sometimes|nullable|string',
        'saml_sso_url'           => 'sometimes|nullable|url',
        'saml_slo_url'           => 'sometimes|nullable|url',
        'saml_cfi'               => 'sometimes|nullable|string',
        'saml_contact_name'      => 'sometimes|nullable|string',
        'saml_contact_email'     => 'sometimes|nullable|email',
        'saml_organization_name' => 'sometimes|nullable|string',
        'saml_website_url'       => 'sometimes|nullable|url',
    ];

    protected static $updateRules = [
        'name'                   => 'sometimes|string',
        'slug'                   => 'sometimes|regex:/^[a-z0-9-]+$/',
        'onelogin_tenant_url'    => 'sometimes|nullable|url',
        'onelogin_api_url'       => 'sometimes|nullable|url',
        'onelogin_client_id'     => 'sometimes|nullable|string',
        'onelogin_secret_key'    => 'sometimes|nullable|string',
        'onelogin_default_role'  => 'sometimes|nullable|integer',
        'duo_integration_key'    => 'sometimes|nullable|string',
        'duo_secret_key'         => 'sometimes|nullable|string',
        'duo_api_url'            => 'sometimes|nullable|string',
        'saml_entity_id'         => 'sometimes|nullable|string',
        'saml_sso_url'           => 'sometimes|nullable|url',
        'saml_slo_url'           => 'sometimes|nullable|url',
        'saml_cfi'               => 'sometimes|nullable|string',
        'saml_contact_name'      => 'sometimes|nullable|string',
        'saml_contact_email'     => 'sometimes|nullable|email',
        'saml_organization_name' => 'sometimes|nullable|string',
        'saml_website_url'       => 'sometimes|nullable|url',
    ];

    /**
     * @param $model
     */
    protected static function endCreate($model): void
    {
        Cache::forget('directory_slugs_list');
        Cache::forget('directory_settings');
    }

    /**
     * @param $model
     */
    protected static function endUpdate($model): void
    {
        Cache::forget('directory_slugs_list');
        Cache::forget('directory_settings');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
