<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
        'name',
    ];

    protected static $createRules = [
        'directory_id' => 'required|integer|exists:directories,id',
        'name'         => 'required|max:255',
    ];

    protected static $updateRules = [
        'directory_id' => 'sometimes|integer|exists:directories,id',
        'name'         => 'sometimes|max:255',
    ];

    /**
     * @param $model
     */
    protected static function endUpdate($model): void
    {
        if (isset($model->xData['applications'])) {
            $rootApplicationRoles = ApplicationRole::where('role_id', $model->id)
                ->whereNotIn('application_id', array_filter($model->xData['applications']))
                ->whereNull('company_id')
                ->get();

            // Delete disabled root application roles
            foreach ($rootApplicationRoles as $rootApplicationRole) {
                $rootApplicationRole->delete();
            }

            // Attach root application roles
            foreach (array_filter($model->xData['applications']) as $applicationId) {
                $applicationRole = ApplicationRole::where('application_id', $applicationId)
                    ->where('role_id', $model->id)
                    ->whereNull('company_id')
                    ->first();

                if (!$applicationRole) {
                    ApplicationRole::create([
                        'application_id' => $applicationId,
                        'role_id'        => $model->id,
                    ]);
                }
            }
        }
    }

    /**
     * @param $model
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected static function endDelete($model): void
    {
        // Delete role users relations of deleted role
        $roleUsers = RoleUser::where('role_id', $model->id)->get();

        foreach ($roleUsers as $roleUser) {
            $roleUser->delete();
        }

        // Delete application roles relations of deleted role
        $applicationRoles = ApplicationRole::where('role_id', $model->id)->get();

        foreach ($applicationRoles as $applicationRole) {
            $applicationRole->delete();
        }
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
    public function applications()
    {
        return $this->belongsToMany(Application::class);
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
