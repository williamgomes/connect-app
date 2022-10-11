<?php

namespace App\Http\Requests\App\Category;

use App\Http\Requests\Request;

class CategoryUpdateRequest extends Request
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
        $category = $this->route()->parameter('category');

        return [
            'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
            'user_id'   => 'sometimes|integer|exists:users,id',
            'name'      => 'sometimes|string|max:255',
            'sla_hours' => 'sometimes|integer|max:48',
        ];
    }
}
