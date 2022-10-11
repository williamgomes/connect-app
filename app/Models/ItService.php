<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItService extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier',
        'name',
        'note',
    ];

    protected static $createRules = [
        'identifier' => 'required|string|min:2|max:6|unique:it_services,identifier',
        'name'       => 'required|string|max:255|unique:it_services,name',
        'note'       => 'sometimes|nullable|string|max:1000',
    ];

    protected static $updateRules = [
        'identifier' => 'sometimes|string|min:2|max:6',
        'name'       => 'sometimes|string|max:255',
        'note'       => 'sometimes|nullable|string|max:1000',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provisionScripts()
    {
        return $this->hasMany(ProvisionScript::class);
    }
}
