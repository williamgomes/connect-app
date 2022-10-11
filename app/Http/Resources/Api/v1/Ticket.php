<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class Ticket extends JsonResource
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
            'id'        => (int) $this->id,
            'user'      => new User($this->user),
            'requester' => new User($this->requester),
            'category'  => new Category($this->category),
            'service'   => new Service($this->service),
            'country'   => new Country($this->country),
            'title'     => (string) $this->title,
            'due_at'    => (string) $this->due_at,
            'status'    => (string) $this->status,
        ];
    }
}
