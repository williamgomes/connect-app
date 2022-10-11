<?php

namespace App\Http\Requests\App\Network;

use App\Http\Requests\Request;

class NetworkCreateRequest extends Request
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
            'name'       => 'required|string|max:255|unique:networks,name',
            'ip_address' => 'required|ipv4',
            'cidr'       => 'required|integer|min:1|max:32',
            'vlan_id'    => 'required|integer|min:0|max:4095',
        ];
    }
}
