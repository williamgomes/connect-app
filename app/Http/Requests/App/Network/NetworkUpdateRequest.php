<?php

namespace App\Http\Requests\App\Network;

use App\Http\Requests\Request;

class NetworkUpdateRequest extends Request
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
        $network = $this->route()->parameter('network');

        return [
            'name'       => 'sometimes|string|max:255|unique:networks,name,' . $network->id,
            'ip_address' => 'sometimes|ipv4',
            'cidr'       => 'sometimes|integer|min:1|max:32',
            'vlan_id'    => 'sometimes|integer|min:0|max:4095',
        ];
    }
}
