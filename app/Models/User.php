<?php

namespace App\Models;

use App\Helpers\ReportHelper;
use App\Jobs\Duo\UpdateUserInDuo;
use App\Jobs\OneLogin\UpdateUserInOneLogin;
use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;
    use BaseModelTrait;
    use HasFactory;

    const IS_ACTIVE = 1;
    const NOT_ACTIVE = 0;

    const ROLE_ADMIN = 10;
    const ROLE_AGENT = 20;
    const ROLE_REPORTING = 25;
    const ROLE_REGULAR = 30;
    const ROLE_DEVELOPER = 40;

    const ENABLE_BLOG_NOTIFICATIONS = 1;
    const DISABLE_BLOG_NOTIFICATIONS = 0;

    public static $roles = [
        self::ROLE_ADMIN     => 'Admin',
        self::ROLE_AGENT     => 'Agent',
        self::ROLE_REPORTING => 'Reporting',
        self::ROLE_REGULAR   => 'End user',
        self::ROLE_DEVELOPER => 'Developer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'synega_id',
        'active',
        'first_name',
        'last_name',
        'default_username',
        'email',
        'phone_number',
        'role',
        'profile_picture',
        'slack_webhook_url',
        'password',
        'blog_notifications',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'slack_webhook_url',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $createRules = [
        'active'             => 'required|boolean',
        'uuid'               => 'required|uuid',
        'synega_id'          => 'required|integer|min:100',
        'first_name'         => 'required|max:125',
        'last_name'          => 'required|max:125',
        'default_username'   => 'required|max:255|unique:users,default_username',
        'email'              => 'required|string|email|max:255|unique:users,email',
        'phone_number'       => 'required|string|regex:/^\+[1-9]\d{1,14}$/|unique:users,phone_number',
        'role'               => 'required|in:' . self::ROLE_ADMIN . ',' . self::ROLE_AGENT . ',' . self::ROLE_REGULAR . ',' . self::ROLE_DEVELOPER . ',' . self::ROLE_REPORTING,
        'blog_notifications' => 'sometimes|boolean',
    ];

    protected static $updateRules = [
        'active'             => 'sometimes|boolean',
        'uuid'               => 'sometimes|uuid',
        'synega_id'          => 'sometimes|integer|min:100',
        'first_name'         => 'sometimes|max:125',
        'last_name'          => 'sometimes|max:125',
        'default_username'   => 'sometimes|max:255',
        'email'              => 'sometimes|string|email|max:255',
        'phone_number'       => 'sometimes|string|regex:/^\+[1-9]\d{1,14}$/',
        'role'               => 'sometimes|in:' . self::ROLE_ADMIN . ',' . self::ROLE_AGENT . ',' . self::ROLE_REGULAR . ',' . self::ROLE_DEVELOPER . ',' . self::ROLE_REPORTING,
        'slack_webhook_url'  => 'sometimes|nullable|url|max:255',
        'blog_notifications' => 'sometimes|boolean',
    ];

    /**
     * @param       $model
     * @param array $data
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        $data['uuid'] = $data['uuid'] ?? Str::uuid()->toString();
        $data['role'] = $data['role'] ?? self::ROLE_REGULAR;
        $data['active'] = $data['active'] ?? self::IS_ACTIVE;
        $data['blog_notifications'] = $data['blog_notifications'] ?? self::ENABLE_BLOG_NOTIFICATIONS;
        $data['password'] = Hash::make($data['password'] ?? Str::random(100));

        // Set Synega ID for the user
        $data['synega_id'] = $data['synega_id'] ?? self::max('users.synega_id') + 1;

        // Start building username with first name (replace spaces with .)
        $username = preg_replace("/\s+/u", '.', $data['first_name']);

        // User only the last, last name
        $lastNameParts = explode(' ', $data['last_name']);
        $username .= '.' . array_pop($lastNameParts);

        // Sanitize the username
        $data['default_username'] = $data['default_username'] ?? self::sanitizeUsername($username);

        return $data;
    }

    protected static function endCreate($model): void
    {
        if (array_key_exists('permissions', $model->xData ?? [])) {
            $model->permissions()->sync($model->xData['permissions']);
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
        // Synega ID should never be changed
        if (isset($data['synega_id'])) {
            unset($data['synega_id']);
        }

        // Sanitize the default_username if set
        if (isset($data['default_username'])) {
            $data['default_username'] = self::sanitizeUsername($data['default_username']);
        }

        return $data;
    }

    /**
     * @param $model
     */
    protected static function endUpdate($model): void
    {
        foreach ($model->directoryUsers as $directoryUser) {
            UpdateUserInDuo::dispatch($directoryUser);
            UpdateUserInOneLogin::dispatch($directoryUser);
        }

        if (array_key_exists('permissions', $model->xData ?? [])) {
            $model->permissions()->sync($model->xData['permissions']);

            foreach (Permission::all() as $permission) {
                $key = 'user_permissions:' . $model->id . ':' . $permission->type;
                Cache::forget($key);
            }
        }
    }

    /**
     * @param $role
     */
    public function scopeActive()
    {
        return $this->where('active', true);
    }

    /**
     * @param $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role == $role;
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public function hasPermission($type): bool
    {
        $key = 'user_permissions:' . $this->id . ':' . $type;

        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $exists = $this->permissions()->where('type', $type)->exists();
            Cache::put($key, $exists, 3600);

            return $exists;
        }
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /*
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    *
    */
    public function verifications()
    {
        return $this->hasMany(UserVerification::class);
    }

    /*
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    *
    */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'requester_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applications()
    {
        return $this->belongsToMany(Application::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applicationUsers()
    {
        return $this->hasMany(ApplicationUser::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleUsers()
    {
        return $this->hasMany(RoleUser::class);
    }

    /**
     * @param string $username
     *
     * @return string
     */
    private static function sanitizeUsername(string $username): string
    {
        // Convert to lowercase
        $username = mb_strtolower($username, 'UTF-8');

        // Replace ÆØÅ in username
        $username = str_replace('æ', 'ae', $username);
        $username = str_replace('ø', 'oe', $username);
        $username = str_replace('å', 'aa', $username);

        return preg_replace('/[^a-z.]/', '', $username);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function directories()
    {
        return $this->belongsToMany(Directory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function directoryUsers()
    {
        return $this->hasMany(DirectoryUser::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function faqs()
    {
        return $this->belongsToMany(Faq::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails()
    {
        return $this->hasMany(UserEmail::class);
    }

    /**
     * Get report folder which user has access to according to reports he has access to.
     * If folderId is given then we get accessible folders among its subfolders only.
     *
     * @param User              $user
     * @param ReportFolder|null $folder
     *
     * @return mixed
     */
    public static function getAvailableReportFolders(self $user, ?ReportFolder $folder = null)
    {
        $reports = $user->reports->unique('folder_id');
        $accessibleFolderIds = $reports->pluck('folder_id')->toArray();

        if ($user->hasRole(self::ROLE_ADMIN)) {
            if ($folder) {
                $folderIds = $folder->subfolders()->pluck('id')->toArray();
            } else {
                $folderIds = ReportFolder::root()->pluck('id')->toArray();
            }
        } else {
            if ($folder) {
                $folderIds = ReportHelper::getSpecificFolderSubfolders($folder, $accessibleFolderIds);
            } else {
                $folderIds = ReportHelper::getRootParentFolders($accessibleFolderIds);
            }
        }

        return ReportFolder::whereIn('id', $folderIds)->orderBy('name')->get();
    }
}
