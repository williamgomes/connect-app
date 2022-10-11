<?php

namespace App\Http\Requests\App\TicketTag;

use App\Http\Requests\Request;

class TicketTagCreateRequest extends Request
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
            'name'        => 'required|string|max:255|unique:ticket_tags,name',
            'description' => 'sometimes|nullable|string|max:1000',
            'active'      => 'required|boolean',
        ];
    }
}
