<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TmsInstance extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const PERIOD_DAY = 'day';
    const PERIOD_MONTH = 'month';
    const PERIOD_YEAR = 'year';

    const TYPE_REVENUE = 'revenue';
    const TYPE_NEW_EMPLOYEES = 'new-employees';
    const TYPE_EMPLOYEE_CONVERSION = 'employee-conversion';
    const TYPE_NEW_USER_LEADS = 'new-user-leads';
    const TYPE_EMPLOYEES_DEACTIVATED = 'employees-deactivated';
    const TYPE_EMPLOYEE_CHURN = 'employee-churn';
    const TYPE_USER_RATINGS = 'user-ratings';
    const TYPE_NEW_CLIENTS = 'new-clients';
    const TYPE_CLIENT_CONVERSION = 'client-conversion';
    const TYPE_NEW_CLIENT_LEADS = 'new-client-leads';
    const TYPE_CLIENTS_DEACTIVATED = 'clients-deactivated';
    const TYPE_CLIENT_CHURN = 'client-churn';
    const TYPE_CLIENT_RATINGS = 'client-ratings';

    public static $types = [
        self::TYPE_REVENUE               => 'Gross Revenue',
        self::TYPE_NEW_EMPLOYEES         => 'New Consultants',
        self::TYPE_EMPLOYEE_CONVERSION   => 'Consultant Conversion',
        self::TYPE_NEW_USER_LEADS        => 'Consultant Leads',
        self::TYPE_EMPLOYEES_DEACTIVATED => 'Consultants Deactivated',
        self::TYPE_EMPLOYEE_CHURN        => 'Consultant Churn',
        self::TYPE_USER_RATINGS          => 'Satisfaction Rating From Consultants',
        self::TYPE_NEW_CLIENTS           => 'New Clients',
        self::TYPE_CLIENT_CONVERSION     => 'Client Conversion',
        self::TYPE_NEW_CLIENT_LEADS      => 'Client Leads',
        self::TYPE_CLIENTS_DEACTIVATED   => 'Clients Deactivated',
        self::TYPE_CLIENT_CHURN          => 'Client Churn',
        self::TYPE_CLIENT_RATINGS        => 'Satisfaction Rating From Clients',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'identifier',
        'base_url',
        'bearer_token',
    ];

    protected static $createRules = [
        'name'         => 'required|string|max:255',
        'identifier'   => 'required|string|min:4|max:4',
        'base_url'     => 'required|url',
        'bearer_token' => 'required|string',
    ];

    protected static $updateRules = [
        'name'         => 'sometimes|string|max:255',
        'identifier'   => 'sometimes|string|min:4|max:4',
        'base_url'     => 'sometimes|url',
        'bearer_token' => 'sometimes|string',
    ];

    /**
     * @return HasMany
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
