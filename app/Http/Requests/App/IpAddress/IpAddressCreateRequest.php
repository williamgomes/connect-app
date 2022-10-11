<?php

namespace App\Http\Requests\App\IpAddress;

use App\Http\Requests\Request;

class IpAddressCreateRequest extends Request
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
            'network_id'   => 'required|integer|exists:networks,id',
            'inventory_id' => 'sometimes|nullable|integer|exists:inventories,id',
            'primary'      => 'sometimes|boolean',
            'address'      => 'required|ipv4|unique:ip_addresses,address',
            'description'  => 'sometimes|nullable|string|max:255',
        ];
    }
}
