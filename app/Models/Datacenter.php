<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datacenter extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'country',
        'location',
        'location_id',
        'note',
    ];

    protected static $createRules = [
        'name'        => 'required|string|max:255|unique:datacenters,name',
        'country'     => 'required|string|min:2|max:2',
        'location'    => 'required|string|min:3|max:3',
        'location_id' => 'required|integer|min:1',
        'note'        => 'sometimes|nullable|string|max:1000',
    ];

    protected static $updateRules = [
        'name'        => 'sometimes|string|max:255',
        'country'     => 'sometimes|string|min:2|max:2',
        'location'    => 'sometimes|string|min:3|max:3',
        'location_id' => 'sometimes|integer|min:1',
        'note'        => 'sometimes|nullable|string|max:1000',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function networks()
    {
        return $this->belongsToMany(Network::class);
    }
}
