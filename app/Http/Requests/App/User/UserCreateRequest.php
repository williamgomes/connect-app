<?php

namespace App\Http\Requests\App\User;

use App\Http\Requests\Request;
use App\Models\User;

class UserCreateRequest extends Request
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
            'active'             => 'sometimes|boolean',
            'first_name'         => 'required|max:125',
            'last_name'          => 'required|max:125',
            'email'              => 'required|string|email|max:255|unique:users,email',
            'phone_number'       => [
                'required',
                'string',
                'regex:/^[1-9]\d{1,14}$/',
                'unique:users,phone_number',
                function ($attribute, $value, $fail) {
                    if (User::where('phone_number', '+' . $value)->exists()) {
                        $fail(__('The phone number has already been taken.'));
                    }
                },
            ],
            'blog_notifications' => 'sometimes|boolean',
        ];
    }
}
