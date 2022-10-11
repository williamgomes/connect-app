<?php

namespace App\Http\Requests\App\TicketPriority;

use App\Http\Requests\Request;

class TicketPriorityCreateRequest extends Request
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
            'order'       => 'required|integer|unique:ticket_priorities,order',
            'name'        => 'required|string|unique:ticket_priorities,name',
            'description' => 'required|string',
        ];
    }
}
