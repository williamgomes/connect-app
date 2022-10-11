<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class ReportBudget extends Model
{
    use BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tms_instance_id',
        'type',
        'period',
        'values',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'values' => 'array',
    ];

    protected static $createRules = [
        'tms_instance_id' => 'required|integer|exists:tms_instances,id',
        'type'            => 'required|string',
        'period'          => 'required|string|in:' . TmsInstance::PERIOD_DAY . ',' . TmsInstance::PERIOD_MONTH . ',' . TmsInstance::PERIOD_YEAR,
        'values'          => 'required|json',
        'values.*'        => 'required|numeric',
    ];

    protected static $updateRules = [
        'tms_instance_id' => 'sometimes|integer|exists:tms_instances,id',
        'type'            => 'sometimes|string',
        'period'          => 'sometimes|string|in:day,month',
        'values'          => 'sometimes|json',
        'values.*'        => 'sometimes|numeric',
    ];

    /**
     * Get the related TMS instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tmsInstance()
    {
        return $this->belongsTo(TmsInstance::class);
    }
}
