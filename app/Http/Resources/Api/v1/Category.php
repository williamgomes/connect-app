<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'name'      => (string) $this->name,
            'parent'    => new self($this->parentCategory),
            'user'      => new User($this->user),
            'sla_hours' => (int) $this->sla_hours,
        ];
    }
}
