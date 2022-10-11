<?php

namespace App\Http\Requests\Api\v1\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
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
            'synega_id'        => 'sometimes|integer|min:100',
            'first_name'       => 'sometimes|string|max:255',
            'last_name'        => 'sometimes|string|max:255',
            'default_username' => 'sometimes|string|max:255',
            'email'            => 'sometimes|email|max:255',
            'phone_number'     => 'sometimes|string|regex:/^\+[1-9]\d{1,14}$/',
        ];
    }
}
