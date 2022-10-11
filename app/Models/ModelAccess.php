<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class ModelAccess extends Model
{
    use BaseModelTrait;

    /**
     * @var string
     */
    protected $table = 'model_accesses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'name',
        'description',
    ];

    protected static $createRules = [
        'model'       => 'required|string|unique:model_accesses,model',
        'name'        => 'required|string|unique:model_accesses,name',
        'description' => 'sometimes|string',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function abilities()
    {
        return $this->hasMany(ModelAccessAbility::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function apiApplications()
    {
        return $this->belongsToMany(ApiApplication::class, 'api_application_model_access');
    }
}
