<?php

namespace App\Http\Requests\App\ApiApplicationToken;

use App\Http\Requests\Request;

class ApiApplicationTokenCreateRequest extends Request
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
        return [
            'api_application_id' => 'sometimes|integer|exists:api_applications,id',
            'created_by'         => 'sometimes|integer|exists:users,id',
            'revoked_by'         => 'sometimes|integer|exists:users,id',
            'identifier'         => 'required|alpha_dash|max:255|unique:api_application_tokens,identifier',
            'token'              => 'required|string|min:100|max:100',
            'last_used_at'       => 'sometimes|date',
            'revoked_at'         => 'sometimes|date',
        ];
    }
}
