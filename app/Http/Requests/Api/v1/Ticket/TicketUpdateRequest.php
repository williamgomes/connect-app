<?php

namespace App\Http\Requests\Api\v1\Ticket;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class TicketUpdateRequest extends FormRequest
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
            'requester_id'   => 'sometimes|integer|exists:users,id',
            'category_id'    => 'sometimes|integer|exists:categories,id',
            'subcategory_id' => 'sometimes|nullable|integer|exists:categories,id',
            'service_id'     => 'sometimes|integer|exists:services,id',
            'country_id'     => 'sometimes|integer|exists:countries,id',
            'title'          => 'sometimes|string|max:255',
            'user_id'        => 'sometimes|nullable|integer|exists:users,id',
            'due_at'         => 'sometimes|date',
            'status'         => 'sometimes|string|in:' . Ticket::STATUS_OPEN . ',' . Ticket::STATUS_CLOSED . ',' . Ticket::STATUS_SOLVED,
        ];
    }
}
