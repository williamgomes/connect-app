<?php

namespace App\Http\Requests\App\Guide;

use App\Http\Requests\Request;

class GuideUpdateRequest extends Request
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
        $guide = $this->route()->parameter('guide');

        return [
            'title'         => 'sometimes|string|max:255|unique:guides,title,' . $guide->id,
            'content'       => 'sometimes|string',
            'inventories'   => 'sometimes|nullable|array',
            'inventories.*' => 'sometimes|integer|exists:inventories,id',
        ];
    }
}
