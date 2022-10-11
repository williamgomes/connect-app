<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'metabase_id',
        'user_id',
        'folder_id',
        'title',
        'description',
    ];

    protected static $createRules = [
        'metabase_id' => 'required|integer',
        'user_id'     => 'required|integer|exists:users,id',
        'folder_id'   => 'required|integer|exists:report_folders,id',
        'title'       => 'required|string|max:255',
        'description' => 'sometimes|nullable|string',
    ];

    protected static $updateRules = [
        'metabase_id' => 'sometimes|integer',
        'user_id'     => 'sometimes|integer|exists:users,id',
        'folder_id'   => 'sometimes|integer|exists:report_folders,id',
        'title'       => 'sometimes|string|max:255',
        'description' => 'sometimes|nullable|string',
    ];

    protected static function endCreate($model): void
    {
        if (array_key_exists('users', $model->xData ?? [])) {
            $model->users()->sync($model->xData['users']);
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
        return $data;
    }

    /**
     * @param $model
     */
    protected static function endUpdate($model): void
    {
        if (array_key_exists('users', $model->xData ?? [])) {
            $model->users()->sync($model->xData['users']);
        }
    }

    /**
     * @param $model
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected static function endDelete($model): void
    {
        $model->users()->sync([]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder()
    {
        return $this->belongsTo(ReportFolder::class, 'folder_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
