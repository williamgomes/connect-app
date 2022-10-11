<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class ProvisionScriptLog extends Model
{
    use BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provision_script_id',
        'inventory_id',
        'content',
    ];

    protected static $createRules = [
        'provision_script_id' => 'required|integer|exists:provision_scripts,id',
        'inventory_id'        => 'required|integer|exists:inventories,id',
        'content'             => 'required|string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provisionScript()
    {
        return $this->belongsTo(ProvisionScript::class);
    }
}
