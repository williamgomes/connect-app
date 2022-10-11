<?php

namespace App\Http\Requests\App\ItService;

use App\Http\Requests\Request;

class ItServiceUpdateRequest extends Request
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
        $itService = $this->route()->parameter('itService');

        return [
            'identifier' => 'sometimes|string|min:2|max:6|unique:it_services,identifier, ' . $itService->id,
            'name'       => 'sometimes|string|max:255|unique:it_services,name,' . $itService->id,
            'note'       => 'sometimes|nullable|string|max:1000',
        ];
    }
}
