<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const IS_PRIMARY = 1;
    const NOT_PRIMARY = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'network_id',
        'inventory_id',
        'primary',
        'address',
        'description',
    ];

    protected static $createRules = [
        'network_id'   => 'required|integer|exists:networks,id',
        'inventory_id' => 'sometimes|nullable|integer|exists:inventories,id',
        'primary'      => 'sometimes|boolean',
        'address'      => 'required|ipv4|unique:ip_addresses,address',
        'description'  => 'sometimes|nullable|string|max:255',
    ];

    protected static $updateRules = [
        'network_id'   => 'sometimes|integer|exists:networks,id',
        'inventory_id' => 'sometimes|nullable|integer|exists:inventories,id',
        'primary'      => 'sometimes|boolean',
        'address'      => 'sometimes|ipv4|unique:ip_addresses,address',
        'description'  => 'sometimes|nullable|string|max:255',
    ];

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePrimary($query)
    {
        return $query->where('primary', self::IS_PRIMARY);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function network()
    {
        return $this->belongsTo(Network::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    protected static function prepareCreate($model, array $data): array
    {
        $data['primary'] = $data['inventory_id'] ? ($data['primary'] ?? 0) : 0;

        return $data;
    }

    protected static function endCreate($model): void
    {
        if ($model->primary == self::IS_PRIMARY && $model->inventory) {
            $model->inventory
                ->ipAddresses()
                ->where('id', '!=', $model->id)
                ->get()
                ->each
                ->update([
                    'primary' => self::NOT_PRIMARY,
                ]);
        }
    }

    protected static function endUpdate($model): void
    {
        if ($model->getOriginal('primary') == self::NOT_PRIMARY && $model->primary == self::IS_PRIMARY && $model->inventory) {
            $model->inventory
                ->ipAddresses()
                ->where('id', '!=', $model->id)
                ->get()
                ->each
                ->update([
                    'primary' => self::NOT_PRIMARY,
                ]);
        }
    }
}
