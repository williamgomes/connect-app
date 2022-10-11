<?php

namespace App\Http\Requests\App\ItService;

use App\Http\Requests\Request;

class ItServiceCreateRequest extends Request
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
            'identifier' => 'required|string|min:2|max:6|unique:it_services,identifier',
            'name'       => 'required|string|max:255|unique:it_services,name',
            'note'       => 'sometimes|nullable|string|max:1000',
        ];
    }
}
