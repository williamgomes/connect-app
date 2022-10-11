<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportFolder extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'user_id',
        'name',
    ];

    protected static $createRules = [
        'parent_id' => 'sometimes|nullable|integer|exists:report_folders,id',
        'user_id'   => 'required|integer|exists:users,id',
        'name'      => 'required|string|max:255',
    ];

    protected static $updateRules = [
        'parent_id' => 'sometimes|nullable|integer|exists:report_folders,id',
        'user_id'   => 'sometimes|integer|exists:users,id',
        'name'      => 'sometimes|string|max:255',
    ];

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get the primary category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentFolder()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the subfolders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subfolders()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the reports.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'folder_id');
    }

    /**
     * Get the related user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function fullPath()
    {
        $path = [];
        $model = clone $this;
        while ($model->parentFolder != null) {
            $model = $model->parentFolder;
            $path[] = $model->name;
        }
        $path = array_reverse($path);

        return (!empty(implode(' → ', $path)) ? (implode(' → ', $path) . ' → ') : '') . $this->name;
    }
}
