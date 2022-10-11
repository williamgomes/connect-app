<?php

namespace App\Http\Requests\Api\v1\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'synega_id'          => 'sometimes|integer|min:100|unique:users,synega_id,' . $user->id,
            'onelogin_id'        => 'sometimes|nullable|integer',
            'duo_id'             => 'sometimes|nullable|string|max:255',
            'active'             => 'sometimes|boolean',
            'first_name'         => 'sometimes|string|max:255',
            'last_name'          => 'sometimes|string|max:255',
            'default_username'   => 'sometimes|string|max:255',
            'email'              => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'phone_number'       => 'sometimes|nullable|string|regex:/^\+[1-9]\d{1,14}$/|unique:users,phone_number,' . $user->id,
            'role'               => 'sometimes|in:' . User::ROLE_ADMIN . ',' . User::ROLE_AGENT . ',' . User::ROLE_REGULAR . ',' . User::ROLE_DEVELOPER . ',' . User::ROLE_REPORTING,
            'slack_webhook_url'  => 'sometimes|nullable|url|max:255',
            'blog_notifications' => 'sometimes|boolean',
        ];
    }
}
