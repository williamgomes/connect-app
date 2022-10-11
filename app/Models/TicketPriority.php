<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPriority extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order',
        'name',
        'description',
    ];

    protected static $createRules = [
        'order'       => 'required|integer|unique:ticket_priorities,order',
        'name'        => 'required|string|unique:ticket_priorities,name',
        'description' => 'required|string',
    ];

    protected static $updateRules = [
        'order'       => 'sometimes|integer',
        'name'        => 'sometimes|string',
        'description' => 'sometimes|string',
    ];

    /**
     * Get the related ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'priority_id');
    }
}
