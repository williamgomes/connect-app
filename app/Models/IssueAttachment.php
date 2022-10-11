<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class IssueAttachment extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issue_id',
        'filename',
        'original_filename',
    ];

    protected static $createRules = [
        'issue_id'          => 'required|exists:issues,id',
        'filename'          => 'required|string',
        'original_filename' => 'required|string',
    ];

    protected static $updateRules = [
        'issue_id'          => 'sometimes|exists:issues,id',
        'filename'          => 'sometimes|string',
        'original_filename' => 'sometimes|string',
    ];

    /**
     * @param $model
     */
    protected static function endDelete($model): void
    {
        if (Storage::has($model->filename)) {
            Storage::delete($model->filename);
        }
    }

    /**
     * Get the issue that owns the attachment.
     */
    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}
