<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiHttpLog extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const OUTGOING = 'outgoing';
    const INCOMING = 'incoming';

    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_HEAD = 'HEAD';
    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_PUT = 'PUT';
    const HTTP_METHOD_DELETE = 'DELETE';
    const HTTP_METHOD_CONNECT = 'CONNECT';
    const HTTP_METHOD_OPTIONS = 'OPTIONS';
    const HTTP_METHOD_TRACE = 'TRACE';
    const HTTP_METHOD_PATCH = 'PATCH';

    public static $httpMethods = [
        self::HTTP_METHOD_GET,
        self::HTTP_METHOD_HEAD,
        self::HTTP_METHOD_POST,
        self::HTTP_METHOD_PUT,
        self::HTTP_METHOD_DELETE,
        self::HTTP_METHOD_CONNECT,
        self::HTTP_METHOD_OPTIONS,
        self::HTTP_METHOD_TRACE,
        self::HTTP_METHOD_PATCH,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'application_token_id',
        'type',
        'ip',
        'http_method',
        'endpoint',
        'request',
        'response',
        'response_code',
        'response_time',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Creation validation rules.
     *
     * @var array
     */
    protected static $createRules = [
        'uuid'                 => 'required|string|max:255',
        'application_token_id' => 'sometimes|nullable|integer|exists:api_application_tokens,id',
        'type'                 => 'required|string|in:' . self::OUTGOING . ',' . self::INCOMING,
        'ip'                   => 'sometimes|nullable|ipv4',
        'http_method'          => 'required|string|in:' . self::HTTP_METHOD_GET . ',' . self::HTTP_METHOD_HEAD . ',' . self::HTTP_METHOD_POST . ',' . self::HTTP_METHOD_PUT . ',' . self::HTTP_METHOD_DELETE . ',' . self::HTTP_METHOD_CONNECT . ',' . self::HTTP_METHOD_OPTIONS . ',' . self::HTTP_METHOD_TRACE . ',' . self::HTTP_METHOD_PATCH,
        'endpoint'             => 'required|string|max:65535',
        'request'              => 'sometimes|nullable|string',
        'response'             => 'sometimes|nullable|string',
        'response_code'        => 'required|integer|min:100|max:509',
        'response_time'        => 'sometimes|integer',
        'expires_at'           => 'required|date',
    ];

    /**
     * Prepare data for create validation.
     *
     * @param $model
     * @param $data
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        $data['expires_at'] = $data['expires_at'] ?? now()->addDays(env('API_HTTP_LOG_EXPIRE_DAYS', 14));

        return $data;
    }
}
