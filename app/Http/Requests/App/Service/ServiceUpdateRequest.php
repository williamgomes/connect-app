<?php

namespace App\Http\Requests\App\Service;

use App\Http\Requests\Request;

class ServiceUpdateRequest extends Request
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
        $service = $this->route()->parameter('service');

        return [
            'identifier' => 'sometimes|string|min:2|max:2|unique:services,identifier, ' . $service->id,
            'name'       => 'sometimes|string|max:255|unique:services,name,' . $service->id,
        ];
    }
}
