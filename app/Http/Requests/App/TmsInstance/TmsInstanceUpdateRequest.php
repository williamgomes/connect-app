<?php

namespace App\Http\Requests\App\TmsInstance;

use Illuminate\Foundation\Http\FormRequest;

class TmsInstanceUpdateRequest extends FormRequest
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
        $record = $this->route()->parameter('tmsInstance');

        return [
            'name'         => 'sometimes|string|max:255|unique:tms_instances,name,' . $record->id,
            'identifier'   => 'sometimes|string|min:4|max:4',
            'base_url'     => 'sometimes|url',
            'bearer_token' => 'sometimes|string',
        ];
    }
}
