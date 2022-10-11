<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class ModelAccessAbility extends Model
{
    use BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_access_id',
        'ability',
        'name',
        'description',
    ];

    protected static $createRules = [
        'model_access_id' => 'required|integer|exists:model_accesses,id',
        'ability'         => 'required|string',
        'name'            => 'required|string',
        'description'     => 'sometimes|string',
    ];

    /**
     * @param array $data
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        $data['description'] = $data['description'] ?? '';

        return $data;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model()
    {
        return $this->belongsTo(ModelAccess::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function apiApplications()
    {
        return $this->belongsToMany(ApiApplication::class, 'api_application_model_access_token');
    }
}
