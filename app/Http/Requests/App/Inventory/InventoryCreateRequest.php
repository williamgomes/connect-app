<?php

namespace App\Http\Requests\App\Inventory;

use App\Http\Requests\Request;
use App\Models\Inventory;

class InventoryCreateRequest extends Request
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
            'type'          => 'required|string|in:' . Inventory::TYPE_SOFTWARE . ',' . Inventory::TYPE_HARDWARE,
            'status'        => 'required|string|in:' . Inventory::STATUS_PRODUCTION . ',' . Inventory::STATUS_DEVELOPMENT . ',' . Inventory::STATUS_STAGING,
            'datacenter_id' => 'required|integer|exists:datacenters,id',
            'it_service_id' => 'required|integer|exists:it_services,id',
            'public_ip'     => 'sometimes|nullable|ipv4',
            'private_ip'    => 'sometimes|nullable|ipv4',
            'note'          => 'sometimes|nullable|string|max:4294967295',
        ];
    }
}
