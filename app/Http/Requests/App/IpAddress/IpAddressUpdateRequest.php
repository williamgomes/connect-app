<?php

namespace App\Http\Requests\App\IpAddress;

use App\Http\Requests\Request;

class IpAddressUpdateRequest extends Request
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
            'primary'     => 'sometimes|boolean',
            'description' => 'sometimes|nullable|string|max:255',
        ];
    }
}
