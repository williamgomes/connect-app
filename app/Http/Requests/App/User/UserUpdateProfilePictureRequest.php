<?php

namespace App\Http\Requests\App\User;

use App\Http\Requests\Request;

class UserUpdateProfilePictureRequest extends Request
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
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|dimensions:min_width=500,min_height=500|max:4096',
            'crop_x'          => 'required|numeric|min:0',
            'crop_y'          => 'required|numeric|min:0',
            'crop_width'      => 'required|numeric|min:500',
            'crop_height'     => 'required|numeric|min:500',
        ];
    }
}
