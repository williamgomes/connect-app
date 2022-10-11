<?php

namespace App\Models;

use App\Mail\VerifyUserIdentity;
use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserVerification extends Model
{
    use BaseModelTrait;

    const STATUS_INITIATED = 'initiated';
    const STATUS_FAILED = 'failed';
    const STATUS_VERIFIED = 'verified';

    public static $statuses = [
        self::STATUS_INITIATED => 'Initiated',
        self::STATUS_FAILED    => 'Failed',
        self::STATUS_VERIFIED  => 'Verified',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'ip_address',
        'status',
        'sms_token',
        'email_token',
    ];

    protected static $createRules = [
        'user_id'     => 'required|exists:users,id',
        'uuid'        => 'required|string',
        'ip_address'  => 'required|ip',
        'status'      => 'required|in:' . self::STATUS_INITIATED . ',' . self::STATUS_FAILED . ',' . self::STATUS_VERIFIED,
        'sms_token'   => 'required|integer|between:10000,99999',
        'email_token' => 'required|string|max:50',
    ];

    protected static $updateRules = [
        'user_id'     => 'sometimes|exists:users,id',
        'uuid'        => 'sometimes|string',
        'ip_address'  => 'sometimes|ip',
        'status'      => 'sometimes|in:' . self::STATUS_INITIATED . ',' . self::STATUS_FAILED . ',' . self::STATUS_VERIFIED,
        'sms_token'   => 'sometimes|integer|between:10000,99999',
        'email_token' => 'sometimes|string|max:50',
    ];

    /**
     * @param       $model
     * @param array $data
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        $data['uuid'] = (string) Str::uuid();
        $data['status'] = self::STATUS_INITIATED;
        $data['sms_token'] = (int) rand(10000, 99999);
        $data['email_token'] = (string) Str::random(50);

        return $data;
    }

    /*
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    *
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $model
     */
    protected static function endCreate($model): void
    {
        Mail::to($model->user)->send(new VerifyUserIdentity($model));
    }
}
