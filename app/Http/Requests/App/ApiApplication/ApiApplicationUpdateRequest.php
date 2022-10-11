<?php

namespace App\Http\Requests\App\ApiApplication;

use App\Http\Requests\Request;

class ApiApplicationUpdateRequest extends Request
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
        $apiApplication = $this->route()->parameter('apiApplication');

        return [
            'name' => 'sometimes|string|max:255|unique:api_applications,name,' . $apiApplication->id,
        ];
    }
}
