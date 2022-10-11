<?php

namespace App\Http\Requests\App\ProvisionScript;

use App\Http\Requests\Request;

class ProvisionScriptCreateRequest extends Request
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
            'it_service_id' => 'required|integer|exists:it_services,id',
            'title'         => 'required|string',
            'content'       => 'required|string',
        ];
    }
}
