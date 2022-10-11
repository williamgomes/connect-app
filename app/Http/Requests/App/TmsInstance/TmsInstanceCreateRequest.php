<?php

namespace App\Http\Requests\App\TmsInstance;

use Illuminate\Foundation\Http\FormRequest;

class TmsInstanceCreateRequest extends FormRequest
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
            'name'         => 'required|string|max:255|unique:tms_instances,name',
            'identifier'   => 'required|string|min:4|max:4',
            'base_url'     => 'required|url',
            'bearer_token' => 'required|string',
        ];
    }
}
