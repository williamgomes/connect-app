<?php

namespace App\Http\Requests\App\Ticket;

use App\Http\Requests\Request;
use App\Models\Category;
use App\Models\Country;
use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Validation\Rule;

class TicketUpdateRequest extends Request
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
            'priority_id'    => 'sometimes|integer|exists:ticket_priorities,id',
            'requester_id'   => 'sometimes|integer|exists:users,id',
            'category_id'    => [
                'sometimes',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('active', Category::IS_ACTIVE),
            ],
            'subcategory_id' => [
                'sometimes',
                'nullable',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('active', Category::IS_ACTIVE),
            ],
            'service_id'     => [
                'sometimes',
                'integer',
                Rule::exists('services', 'id')
                    ->where('active', Service::IS_ACTIVE),
            ],
            'country_id'     => [
                'sometimes',
                'integer',
                Rule::exists('countries', 'id')
                    ->where('active', Country::IS_ACTIVE),
            ],
            'title'          => 'sometimes|string|max:255',
            'comment'        => 'sometimes|string',
            'user_id'        => 'sometimes|nullable|integer|exists:users,id',
            'due_at'         => 'sometimes|date',
            'status'         => 'sometimes|string|in:' . Ticket::STATUS_OPEN . ',' . Ticket::STATUS_CLOSED . ',' . Ticket::STATUS_SOLVED,
        ];
    }
}
