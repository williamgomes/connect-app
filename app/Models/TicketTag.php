<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketTag extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const IS_ACTIVE = 1;
    const NOT_ACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    protected static $createRules = [
        'name'        => 'required|string|max:255|unique:ticket_tags,name',
        'description' => 'sometimes|nullable|string|max:1000',
        'active'      => 'required|boolean',
    ];

    protected static $updateRules = [
        'name'        => 'sometimes|string|max:255',
        'description' => 'sometimes|nullable|string|max:1000',
        'active'      => 'sometimes|boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }
}
