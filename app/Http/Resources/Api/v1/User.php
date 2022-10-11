<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'id'                 => (int) $this->id,
            'synega_id'          => (int) $this->synega_id,
            'onelogin_id'        => is_null($this->onelogin_id) ? null : (int) $this->onelogin_id,
            'duo_id'             => is_null($this->duo_id) ? null : (string) $this->duo_id,
            'active'             => (bool) $this->active,
            'first_name'         => (string) $this->first_name,
            'last_name'          => (string) $this->last_name,
            'default_username'   => (string) $this->default_username,
            'email'              => (string) $this->email,
            'phone_number'       => is_null($this->phone_number) ? null : (int) $this->phone_number,
            'role'               => (int) $this->role,
            'slack_webhook_url'  => is_null($this->slack_webhook_url) ? null : (string) $this->slack_webhook_url,
            'blog_notifications' => (bool) $this->blog_notifications,
        ];
    }
}
