<?php

namespace App\Http\Requests\App\TicketPriority;

use App\Http\Requests\Request;

class TicketPriorityUpdateRequest extends Request
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
        $ticketPriority = $this->route()->parameter('ticketPriority');

        return [
            'order'       => 'sometimes|integer|unique:ticket_priorities,order,' . $ticketPriority->id,
            'name'        => 'sometimes|string|unique:ticket_priorities,name,' . $ticketPriority->id,
            'description' => 'sometimes|string',
        ];
    }
}
