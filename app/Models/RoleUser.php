<?php

namespace App\Models;

use App\Jobs\SyncUserApplications;
use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class RoleUser extends Model
{
    use BaseModelTrait;
    use HasFactory;

    protected $table = 'role_user';

    protected $fillable = [
        'role_id',
        'user_id',
        'company_id',
    ];

    public $timestamps = false;

    protected static $createRules = [
        'role_id'    => 'required|integer|exists:roles,id',
        'user_id'    => 'required|integer|exists:users,id',
        'company_id' => 'required|integer|exists:companies,id',
    ];

    protected static $updateRules = [
        'role_id'    => 'sometimes|integer|exists:roles,id',
        'user_id'    => 'sometimes|integer|exists:users,id',
        'company_id' => 'sometimes|integer|exists:companies,id',
    ];

    /**
     * @param       $model
     * @param array $data
     *
     * @throws ValidationException
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        $roleUserExists = self::where('role_id', $data['role_id'])
            ->where('company_id', $data['company_id'])
            ->where('user_id', $data['user_id'])
            ->first();

        if ($roleUserExists) {
            throw ValidationException::withMessages(['The user is already assigned to this role of this company.']);
        }

        return $data;
    }

    /**
     * @param $model
     */
    protected static function endCreate($model): void
    {
        if ($directoryId = $model->company->directory_id) {
            $directoryUser = DirectoryUser::where('directory_id', $directoryId)
                ->where('user_id', $model->user_id)
                ->exists();

            if (!$directoryUser) {
                DirectoryUser::create([
                    'directory_id' => $directoryId,
                    'user_id'      => $model->user_id,
                ]);
            }
        }

        SyncUserApplications::dispatch($model->user);
    }

    /**
     * @param $model
     */
    protected static function endDelete($model): void
    {
        // Re-sync Applications in OneLogin
        SyncUserApplications::dispatch($model->user);

        // If user has no other company of that directory, then remove directory_user relationship.
        $user = $model->user;
        $directoryId = $model->company->directory_id;

        $companyCount = User::select('companies.*')
            ->join('role_user', 'role_user.user_id', 'users.id')
            ->join('companies', 'companies.id', 'role_user.company_id')
            ->where('companies.directory_id', $directoryId)
            ->where('users.id', $user->id)
            ->groupBy('companies.id')
            ->count();

        if (!$companyCount) {
            $directoryUser = optional(DirectoryUser::where('directory_id', $directoryId)
                ->where('user_id', $model->user_id)
                ->first())->delete();
        }
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
