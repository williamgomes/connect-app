<?php

namespace App\Http\Requests\App\Guide;

use App\Http\Requests\Request;

class GuideCreateRequest extends Request
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
            'title'         => 'required|string|max:255|unique:guides,title',
            'content'       => 'required|string',
            'inventories'   => 'sometimes|nullable|array',
            'inventories.*' => 'sometimes|integer|exists:inventories,id',
        ];
    }
}
