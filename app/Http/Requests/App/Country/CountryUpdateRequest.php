<?php

namespace App\Http\Requests\App\Country;

use App\Http\Requests\Request;

class CountryUpdateRequest extends Request
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
        $country = $this->route()->parameter('country');

        return [
            'identifier' => 'sometimes|string|min:2|max:2|unique:countries,identifier, ' . $country->id,
            'name'       => 'sometimes|string|max:100|unique:countries,name,' . $country->id,
        ];
    }
}
