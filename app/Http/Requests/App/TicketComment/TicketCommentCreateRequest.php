<?php

namespace App\Http\Requests\App\TicketComment;

use App\Http\Requests\Request;

class TicketCommentCreateRequest extends Request
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
            'user_id'       => 'sometimes|integer|exists:users,id',
            'ticket_id'     => 'sometimes|integer|exists:tickets,id',
            'content'       => 'required|string',
            'private'       => 'sometimes|boolean',
            'public'        => 'sometimes|string',
            'attachments'   => 'sometimes|array',
            'attachments.*' => 'sometimes|file',
        ];
    }
}
