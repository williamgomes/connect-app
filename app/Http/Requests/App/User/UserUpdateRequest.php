<?php

namespace App\Http\Requests\App\User;

use App\Http\Requests\Request;
use App\Models\User;

class UserUpdateRequest extends Request
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
        $user = $this->route()->parameter('user');

        return [
            'active'             => 'sometimes|boolean',
            'first_name'         => 'sometimes|max:125',
            'last_name'          => 'sometimes|max:125',
            'default_username'   => 'sometimes|max:255|unique:users,default_username,' . $user->id,
            'email'              => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number'       => 'sometimes|string|regex:/^\+[1-9]\d{1,14}$/|unique:users,phone_number,' . $user->id,
            'role'               => 'sometimes|in:' . User::ROLE_ADMIN . ',' . User::ROLE_AGENT . ',' . User::ROLE_REGULAR . ',' . User::ROLE_DEVELOPER . ',' . User::ROLE_REPORTING,
            'slack_webhook_url'  => 'sometimes|nullable|url|max:255',
            'blog_notifications' => 'sometimes|boolean',
        ];
    }
}
