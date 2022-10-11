<?php

namespace App\Http\Requests\App\Category;

use App\Http\Requests\Request;

class CategoryCreateRequest extends Request
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
            'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
            'user_id'   => 'required|integer|exists:users,id',
            'name'      => 'required|string|max:255',
            'sla_hours' => 'required|integer|max:48',
        ];
    }
}
