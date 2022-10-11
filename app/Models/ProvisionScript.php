<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvisionScript extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'it_service_id',
        'title',
        'content',
    ];

    protected static $createRules = [
        'it_service_id' => 'required|integer|exists:it_services,id',
        'title'         => 'required|string',
        'content'       => 'required|string',
    ];

    protected static $updateRules = [
        'it_service_id' => 'sometimes|integer|exists:it_services,id',
        'title'         => 'sometimes|string',
        'content'       => 'sometimes|string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function itService()
    {
        return $this->belongsTo(ItService::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inventories()
    {
        return $this->belongsToMany(Inventory::class);
    }
}
