<?php

namespace App\Http\Requests\Api\v1\Ticket;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class TicketCreateRequest extends FormRequest
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
            'user_id'         => 'sometimes|integer|nullable|exists:users,id',
            'comment_user_id' => 'required|integer|nullable|exists:users,id',
            'requester_id'    => 'required|integer|exists:users,id',
            'category_id'     => 'required|integer|exists:categories,id',
            'subcategory_id'  => 'sometimes|nullable|integer|exists:categories,id',
            'service_id'      => 'required|integer|exists:services,id',
            'country_id'      => 'required|integer|exists:countries,id',
            'title'           => 'required|string|max:255',
            'comment'         => 'required|string',
            'due_at'          => 'sometimes|date',
            'status'          => 'sometimes|string|in:' . Ticket::STATUS_OPEN . ',' . Ticket::STATUS_CLOSED . ',' . Ticket::STATUS_SOLVED,
            'attachments'     => 'sometimes|array',
            'attachments.*'   => 'sometimes|file',
        ];
    }
}
