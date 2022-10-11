<?php

namespace App\Helpers;

use App\Models\Directory;
use Illuminate\Support\Facades\Http;

class OneLoginHelper
{
    /**
     * Generate Onelogin token.
     *
     * @param Directory $directory
     *
     * @throws \Illuminate\Http\Client\RequestException
     *
     * @return string
     */
    public function generateToken(Directory $directory): string
    {
        $response = Http::log()->withBasicAuth($directory->onelogin_client_id, $directory->onelogin_secret_key)
            ->post($directory->onelogin_api_url . '/auth/oauth2/v2/token', [
                'grant_type' => 'client_credentials',
            ]);

        // Throw an exception if a client or server error occur
        $response->throw();

        return $response['access_token'];
    }

    /**
     * Revoke Onelogin token.
     *
     * @param Directory $directory
     * @param string    $token
     *
     * @throws \Illuminate\Http\Client\RequestException
     *
     * @return bool
     */
    public function revokeToken(Directory $directory, string $token): bool
    {
        $response = Http::log()->withBasicAuth($directory->onelogin_client_id, $directory->onelogin_secret_key)
            ->post($directory->onelogin_api_url . '/auth/oauth2/revoke', [
                'access_token' => $token,
            ]);

        // Throw an exception if a client or server error occur
        $response->throw();

        return !$response['status']['error'];
    }
}
