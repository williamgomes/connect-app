<?php

namespace App\Http\Requests\App\CategoryField;

use App\Http\Requests\Request;
use App\Models\CategoryField;

class CategoryFieldCreateRequest extends Request
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
            'type'          => 'required|string',
            'title'         => 'required|string',
            'description'   => 'sometimes|nullable|string',
            'placeholder'   => 'sometimes|nullable|string',
            'options'       => 'required_if:type,' . CategoryField::TYPE_DROPDOWN . ',' . CategoryField::TYPE_MULTIPLE . '|nullable|array',
            'default_value' => 'sometimes|nullable|string',
            'required'      => 'required|boolean',
            'min'           => 'sometimes|nullable|numeric',
            'max'           => 'sometimes|nullable|numeric',
        ];
    }
}
