<?php

namespace App\Models;

use App\Jobs\OneLogin\SyncApplicationStatusWithOneLogin;
use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationUser extends Model
{
    use BaseModelTrait;
    use HasFactory;

    protected $table = 'application_user';

    const IS_PROVISIONED = 1;
    const NOT_PROVISIONED = 0;

    const IS_DIRECT = 1;
    const NOT_DIRECT = 0;

    const IS_ACTIVE = 1;
    const NOT_ACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'application_id',
        'user_id',
        'provisioned',
        'direct',
        'active',
        'password',
    ];

    protected static $createRules = [
        'application_id' => 'required|integer|exists:applications,id',
        'user_id'        => 'required|integer|exists:users,id',
        'provisioned'    => 'required|boolean',
        'active'         => 'required|boolean',
        'password'       => 'sometimes|nullable|string|max:255',
    ];

    protected static $updateRules = [
        'application_id' => 'sometimes|integer|exists:applications,id',
        'user_id'        => 'sometimes|integer|exists:users,id',
        'provisioned'    => 'sometimes|boolean',
        'active'         => 'sometimes|boolean',
        'password'       => 'sometimes|nullable|string|max:255',
    ];

    /**
     * @param       $model
     * @param array $data
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        $data['active'] = $data['active'] ?? self::IS_ACTIVE;
        $data['direct'] = $data['direct'] ?? self::NOT_DIRECT;

        return $data;
    }

    /**
     * @param $model
     */
    protected static function endCreate($model): void
    {
        SyncApplicationStatusWithOneLogin::dispatch($model);
    }

    /**
     * @param       $model
     * @param array $data
     *
     * @return array
     */
    protected static function prepareUpdate($model, array $data): array
    {
        $input['direct'] = $input['direct'] ?? $model->direct;

        return $data;
    }

    /**
     * @param $model
     */
    protected static function endUpdate($model): void
    {
        SyncApplicationStatusWithOneLogin::dispatch($model, $model->getOriginal('active'));
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
