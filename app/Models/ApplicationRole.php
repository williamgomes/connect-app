<?php

namespace App\Models;

use App\Jobs\SyncRoleApplications;
use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class ApplicationRole extends Model
{
    use BaseModelTrait;

    protected $table = 'application_role';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'application_id',
        'role_id',
        'company_id',
    ];

    protected static $createRules = [
        'application_id' => 'required|integer|exists:applications,id',
        'role_id'        => 'required|integer|exists:roles,id',
        'company_id'     => 'sometimes|nullable|integer|exists:companies,id',
    ];

    protected static $updateRules = [
        'application_id' => 'sometimes|integer|exists:applications,id',
        'role_id'        => 'sometimes|integer|exists:roles,id',
        'company_id'     => 'sometimes|nullable|integer|exists:companies,id',
    ];

    /**
     * @param $model
     */
    protected static function endCreate($model): void
    {
        SyncRoleApplications::dispatch($model->role);
    }

    /**
     * @param $model
     */
    protected static function endDelete($model): void
    {
        SyncRoleApplications::dispatch($model->role);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
