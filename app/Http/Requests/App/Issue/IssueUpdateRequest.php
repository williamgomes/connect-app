<?php

namespace App\Http\Requests\App\Issue;

use App\Http\Requests\Request;
use App\Models\Issue;

class IssueUpdateRequest extends Request
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
            'author_id'   => 'sometimes|integer|exists:users,id',
            'title'       => 'sometimes|string|max:255',
            'key'         => 'sometimes|nullable|string|max:255',
            'type'        => 'sometimes|string|in:' . Issue::TYPE_BUG . ',' . Issue::TYPE_FEATURE,
            'status'      => 'sometimes|string|in:' . implode(',', array_keys(Issue::$statuses)),
            'description' => 'sometimes|string',
        ];
    }
}
