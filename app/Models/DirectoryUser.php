<?php

namespace App\Models;

use App\Environment;
use App\Jobs\Duo\CreateUserInDuo;
use App\Jobs\Duo\DeleteUserInDuo;
use App\Jobs\OneLogin\CreateUserInOneLogin;
use App\Jobs\OneLogin\DeleteUserInOneLogin;
use App\Jobs\OneLogin\UpdateUserInOneLogin;
use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * The model for the DirectoryUser entity.
 */
class DirectoryUser extends Model
{
    use BaseModelTrait;

    protected $table = 'directory_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'directory_id',
        'user_id',
        'onelogin_id',
        'duo_id',
        'username',
    ];

    protected static $createRules = [
        'directory_id' => 'required|integer|exists:directories,id',
        'user_id'      => 'required|integer|exists:users,id',
        'onelogin_id'  => 'sometimes|nullable|integer',
        'duo_id'       => 'sometimes|nullable|string|max:255',
        'username'     => 'sometimes|string|max:255',
    ];

    protected static $updateRules = [
        'directory_id' => 'sometimes|integer|exists:directories,id',
        'user_id'      => 'sometimes|integer|exists:users,id',
        'onelogin_id'  => 'sometimes|nullable|integer',
        'duo_id'       => 'sometimes|nullable|string|max:255',
        'username'     => 'sometimes|string|max:255',
    ];

    /**
     * @param array $data
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        if (!isset($data['username'])) {
            $user = User::find($data['user_id']);
            $username = $user->default_username;

            if (Environment::shouldExecute()) {
                $usersWithSameUsername = self::where('directory_id', $data['directory_id'])
                    ->where(function ($query) use ($username) {
                        $query->where('username', $username)
                            ->orWhere('username', 'regexp', $username . '_[0-9]+');
                    })->get();

                if ($usersWithSameUsername->count()) {
                    $lastUsername = $usersWithSameUsername->last()->username;

                    $lastUsernameArray = explode('_', $lastUsername);
                    $lastUsernameNumber = end($lastUsernameArray);

                    $username = $username . '_' . ((int) $lastUsernameNumber + 1);
                }
            }

            $data['username'] = $username;
        }

        return $data;
    }

    protected static function endCreate($model): void
    {
        // Handle creations in DUO/OneLogin
        CreateUserInDuo::dispatch($model);
        CreateUserInOneLogin::dispatch($model);
    }

    protected static function endUpdate($model): void
    {
        // Handle update in OneLogin
        UpdateUserInOneLogin::dispatch($model);
    }

    protected static function endDelete($model): void
    {
        // Handle deletions in DUO/OneLogin
        DeleteUserInDuo::dispatch($model->directory, $model->duo_id);
        DeleteUserInOneLogin::dispatch($model->directory, $model->onelogin_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function directory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Directory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
