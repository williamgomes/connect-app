<?php

namespace App\Http\Requests\App\Service;

use App\Http\Requests\Request;

class ServiceCreateRequest extends Request
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
            'identifier' => 'required|string|min:2|max:2|unique:services,identifier',
            'name'       => 'required|string|max:255|unique:services,name',
        ];
    }
}
