<?php

namespace App\Http\Requests\App\Directory;

use Illuminate\Foundation\Http\FormRequest;

class DirectoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $record = $this->route()->parameter('directory');

        return [
            'name'                   => 'sometimes|string|max:255|unique:directories,name,' . $record->id,
            'slug'                   => 'sometimes|regex:/^[a-z0-9-]+$/|unique:directories,slug,' . $record->id,
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
    }
}
