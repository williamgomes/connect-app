<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Inventory extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const COMPANY_IDENTIFIER = 'SYN';

    const TYPE_HARDWARE = 'hardware';
    const TYPE_SOFTWARE = 'software';

    const STATUS_PRODUCTION = 'production';
    const STATUS_DEVELOPMENT = 'development';
    const STATUS_STAGING = 'staging';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'identifier',
        'hostname',
        'company',
        'status',
        'type',
        'datacenter_id',
        'it_service_id',
        'note',
    ];

    protected static $createRules = [
        'uuid'          => 'required|uuid',
        'identifier'    => 'required|string|max:30|unique:inventories,identifier',
        'hostname'      => 'required|string|unique:inventories,hostname',
        'company'       => 'required|string|min:3|max:3',
        'type'          => 'required|string',
        'status'        => 'required|string',
        'datacenter_id' => 'required|integer|exists:datacenters,id',
        'it_service_id' => 'required|integer|exists:it_services,id',
        'note'          => 'sometimes|nullable|string|max:4294967295',
    ];

    protected static $updateRules = [
        'uuid'          => 'sometimes|uuid',
        'identifier'    => 'sometimes|string|max:30',
        'hostname'      => 'sometimes|string',
        'company'       => 'sometimes|string|min:3|max:3',
        'type'          => 'sometimes|string',
        'status'        => 'sometimes|string',
        'datacenter_id' => 'sometimes|integer|exists:datacenters,id',
        'it_service_id' => 'sometimes|integer|exists:it_services,id',
        'note'          => 'sometimes|nullable|string|max:4294967295',
    ];

    protected static function prepareCreate($model, array $data): array
    {
        $datacenter = Datacenter::find($data['datacenter_id']);
        $itService = ItService::find($data['it_service_id']);

        $data['identifier'] = $data['identifier'] ?? $model->prepareIdentifier($data['status'], $data['type'], $datacenter, $itService);
        $data['company'] = self::COMPANY_IDENTIFIER;
        $identifierArray = explode('-', $data['identifier']);
        $data['hostname'] = strtolower(end($identifierArray));
        $data['uuid'] = $data['uuid'] ?? Str::uuid()->toString();

        return $data;
    }

    protected static function endCreate($model): void
    {
        if (array_key_exists('guides', $model->xData ?? [])) {
            $model->guides()->sync($model->xData['guides']);
        }
    }

    protected static function endUpdate($model): void
    {
        $identifier = $model->prepareIdentifier();
        $identifierArray = explode('-', $identifier);

        DB::table('inventories')->where('id', $model->id)->update([
            'identifier' => $identifier,
            'hostname'   => strtolower(end($identifierArray)),
        ]);

        if (array_key_exists('guides', $model->xData ?? [])) {
            $model->guides()->sync($model->xData['guides']);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function itService()
    {
        return $this->belongsTo(ItService::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function datacenter()
    {
        return $this->belongsTo(Datacenter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ipAddresses()
    {
        return $this->hasMany(IpAddress::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function provisionScripts()
    {
        return $this->belongsToMany(ProvisionScript::class)->withPivot('content');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guides()
    {
        return $this->belongsToMany(Guide::class);
    }

    /**
     * @param null $status
     * @param null $type
     * @param null $datacenter
     * @param null $itService
     *
     * @return string
     */
    private function prepareIdentifier($status = null, $type = null, $datacenter = null, $itService = null): string
    {
        $status = $status ?? $this->status;
        $type = $type ?? $this->type;
        $datacenter = $datacenter ?? $this->datacenter;
        $itService = $itService ?? $this->itService;

        if ($this->id) {
            $id = $this->id;
        } else {
            $statement = DB::select("SHOW TABLE STATUS LIKE 'inventories'");
            $id = $statement[0]->Auto_increment;
        }

        $identifier = self::COMPANY_IDENTIFIER . '-';
        $identifier .= $datacenter->country . '-';
        $identifier .= $datacenter->location . $datacenter->location_id . '-';
        $identifier .= strtoupper(substr($status, 0, 1)) . strtoupper(substr($type, 0, 1)) . '-';
        $identifier .= $itService->identifier . $id;

        return $identifier;
    }
}
