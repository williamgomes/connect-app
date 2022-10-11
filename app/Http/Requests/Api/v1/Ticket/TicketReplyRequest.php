<?php

namespace App\Http\Requests\Api\v1\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketReplyRequest extends FormRequest
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
            'user_id'       => 'required|integer|exists:users,id',
            'content'       => 'required|string',
            'private'       => 'required|boolean',
            'attachments'   => 'sometimes|array',
            'attachments.*' => 'sometimes|file',
        ];
    }
}
