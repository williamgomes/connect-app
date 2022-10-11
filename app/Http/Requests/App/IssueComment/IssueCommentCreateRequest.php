<?php

namespace App\Http\Requests\App\IssueComment;

use App\Http\Requests\Request;

class IssueCommentCreateRequest extends Request
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
            'issue_id' => 'sometimes|integer|exists:issues,id',
            'content'  => 'required|string',
        ];
    }
}
