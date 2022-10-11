<?php

namespace App\Models;

use App\Jobs\OneLogin\CreateOneLoginRole;
use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'directory_id',
        'onelogin_role_id',
        'onelogin_app_id',
        'name',
        'sso',
        'provisioning',
        'signup_url',
    ];

    protected static $createRules = [
        'directory_id'    => 'required|integer|exists:directories,id',
        'name'            => 'required|string|max:255|unique:applications,name',
        'onelogin_app_id' => 'required|integer|unique:applications,onelogin_app_id',
        'sso'             => 'required|boolean',
        'provisioning'    => 'required|boolean',
        'signup_url'      => 'sometimes|nullable|string|url',
    ];

    protected static $updateRules = [
        'directory_id'     => 'sometimes|integer|exists:directories,id',
        'name'             => 'sometimes|string|max:255',
        'onelogin_role_id' => 'sometimes|integer',
        'onelogin_app_id'  => 'sometimes|integer',
        'sso'              => 'sometimes|boolean',
        'provisioning'     => 'sometimes|boolean',
        'signup_url'       => 'sometimes|nullable|string|url',
    ];

    protected static function endCreate($model): void
    {
        // Create Role and assign App in OneLogin
        CreateOneLoginRole::dispatch($model);
    }

    /**
     * @param       $model
     * @param array $data
     *
     * @return array
     */
    protected static function prepareUpdate($model, array $data): array
    {
        if (isset($data['directory_id']) && !is_null($model->getOriginal('directory_id'))) {
            unset($data['directory_id']);
        }

        return $data;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Get the related directory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function directory()
    {
        return $this->belongsTo(Directory::class);
    }
}
