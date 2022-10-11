<?php

namespace App\Models;

use App\Environment;
use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use IPv4\SubnetCalculator;

class Network extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'ip_address',
        'cidr',
        'vlan_id',
        'gateway',
        'broadcast',
        'address_from',
        'address_to',
        'total_hosts',
        'usable_hosts',
    ];

    protected static $createRules = [
        'name'         => 'required|string|max:255|unique:networks,name',
        'ip_address'   => 'required|ipv4',
        'cidr'         => 'required|integer|min:1|max:32',
        'vlan_id'      => 'required|integer|min:0|max:4095',
        'gateway'      => 'required|ipv4',
        'broadcast'    => 'required|ipv4',
        'address_from' => 'required|ipv4',
        'address_to'   => 'required|ipv4',
        'total_hosts'  => 'required|integer',
        'usable_hosts' => 'required|integer',
    ];

    protected static $updateRules = [
        'name'         => 'sometimes|string|max:255|unique:networks,name',
        'ip_address'   => 'sometimes|ipv4',
        'cidr'         => 'sometimes|integer|min:1|max:32',
        'vlan_id'      => 'sometimes|integer|min:0|max:4095',
        'gateway'      => 'sometimes|ipv4',
        'broadcast'    => 'sometimes|ipv4',
        'address_from' => 'sometimes|ipv4',
        'address_to'   => 'sometimes|ipv4',
        'total_hosts'  => 'sometimes|integer',
        'usable_hosts' => 'sometimes|integer',
    ];

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
    public function datacenters()
    {
        return $this->belongsToMany(Datacenter::class);
    }

    /**
     * @param       $model
     * @param array $data
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        $data = array_merge($data, self::prepareSubnetData($data['ip_address'], $data['cidr']));

        return $data;
    }

    /**
     * @param $model
     *
     * @throws ValidationException
     */
    protected static function endCreate($model)
    {
        $model->validateRange();

        if (array_key_exists('datacenters', $model->xData ?? [])) {
            $model->datacenters()->sync($model->xData['datacenters']);
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
        $data = array_merge($data, self::prepareSubnetData($model->ip_address, $model->cidr));

        return $data;
    }

    /**
     * @param $model
     *
     * @throws ValidationException
     */
    protected static function endUpdate($model)
    {
        // Enable IP addresses validation only on production (disable on local and testing)
        if (Environment::shouldExecute()) {
            $model->validateRange();
            $model->validateUsedAddresses();
        }

        if (array_key_exists('datacenters', $model->xData)) {
            $model->datacenters()->sync($model->xData['datacenters']);
        }
    }

    /**
     * @param $ipAddress
     * @param $cidr
     *
     * @return array
     */
    protected static function prepareSubnetData($ipAddress, $cidr)
    {
        $subnetCalculator = new SubnetCalculator($ipAddress, $cidr);

        $ipAddressesNumber = $subnetCalculator->getNumberIPAddresses();
        $hostsNumber = $subnetCalculator->getNumberAddressableHosts();
        $range = $subnetCalculator->getIPAddressRange();
        $hostRange = $subnetCalculator->getAddressableHostRange();

        $data['broadcast'] = $range[1];
        $data['address_from'] = $data['gateway'] = $hostRange[0];
        $data['address_to'] = $hostRange[1];
        $data['total_hosts'] = $ipAddressesNumber;
        $data['usable_hosts'] = $hostsNumber;

        return $data;
    }

    /**
     * @throws ValidationException
     */
    protected function validateRange()
    {
        $subnetCalculator = new SubnetCalculator($this->ip_address, $this->cidr);
        $networks = self::where('id', '!=', $this->id)->get();

        foreach ($subnetCalculator->getAllIPAddresses() as $ipAddress) {
            foreach ($networks as $network) {
                $subnetSecondaryCalculator = new SubnetCalculator($network->ip_address, $network->cidr);

                if ($subnetSecondaryCalculator->isIPAddressInSubnet($ipAddress)) {
                    throw ValidationException::withMessages(['The IP address (' . $ipAddress . ') of the range already in another network (' . $network->ip_address . '/' . $network->cidr . ') range']);
                }
            }
        }
    }

    /**
     * @throws ValidationException
     */
    protected function validateUsedAddresses()
    {
        $subnetCalculator = new SubnetCalculator($this->ip_address, $this->cidr);
        $ipAddresses = $this->ipAddresses;

        foreach ($ipAddresses as $ipAddress) {
            if (!$subnetCalculator->isIPAddressInSubnet($ipAddress->address)) {
                throw ValidationException::withMessages(['The reserved IP address (' . $ipAddress->address . ') can\'t be out of range.']);
            }
        }
    }
}
