<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketComment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => (int) $this->id,
            'ticket'     => new Ticket($this->ticket),
            'user'       => new User($this->user),
            'private'    => (bool) $this->private,
            'content'    => (string) $this->content,
            'created_at' => (string) $this->created_at,
        ];
    }
}
