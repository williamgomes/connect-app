<?php

namespace App\Models;

use App\Mail\NewBlogPost;
use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class BlogPost extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const STATUS_VISIBLE = 'visible';
    const STATUS_DRAFT = 'draft';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
        'category',
        'title',
        'content',
    ];

    protected static $createRules = [
        'user_id'  => 'required|integer|exists:users,id',
        'status'   => 'required|string|in:' . self::STATUS_VISIBLE . ',' . self::STATUS_DRAFT,
        'category' => 'required|string|max:255',
        'title'    => 'required|string|max:255',
        'content'  => 'required|string',
    ];

    protected static $updateRules = [
        'user_id'  => 'sometimes|integer|exists:users,id',
        'status'   => 'sometimes|string|in:' . self::STATUS_VISIBLE . ',' . self::STATUS_DRAFT,
        'category' => 'sometimes|string|max:255',
        'title'    => 'sometimes|string|max:255',
        'content'  => 'sometimes|string',
    ];

    /**
     * @param array $data
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        $data['status'] = $data['status'] ?? self::STATUS_VISIBLE;

        return $data;
    }

    /**
     * @param $model
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected static function endCreate($model): void
    {
        if ($model->status == self::STATUS_VISIBLE) {
            $users = User::where('active', User::IS_ACTIVE)
                ->where('blog_notifications', User::ENABLE_BLOG_NOTIFICATIONS)
                ->get();

            foreach ($users as $user) {
                Mail::to($user->email)->send(new NewBlogPost($model, $user));
            }
        }
    }

    /**
     * Get the user that owns the note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
