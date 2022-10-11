<?php

namespace App\Http\Requests\App\BlogPost;

use App\Http\Requests\Request;
use App\Models\BlogPost;

class BlogPostCreateRequest extends Request
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
            'user_id'  => 'sometimes|integer|exists:users,id',
            'status'   => 'sometimes|string|in:' . BlogPost::STATUS_VISIBLE . ',' . BlogPost::STATUS_DRAFT,
            'category' => 'required|string|max:255',
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
        ];
    }
}
