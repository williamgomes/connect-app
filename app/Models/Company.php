<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'service_id',
        'tms_instance_id',
        'directory_id',
        'name',
    ];

    protected static $createRules = [
        'directory_id'    => 'required|integer|exists:directories,id',
        'country_id'      => 'required|integer|exists:countries,id',
        'service_id'      => 'required|integer|exists:services,id',
        'tms_instance_id' => 'sometimes|nullable|integer|exists:tms_instances,id',
        'name'            => 'required|string|max:255',
    ];

    protected static $updateRules = [
        'directory_id'    => 'sometimes|integer|exists:directories,id',
        'country_id'      => 'sometimes|integer|exists:countries,id',
        'service_id'      => 'sometimes|integer|exists:services,id',
        'tms_instance_id' => 'sometimes|nullable|integer|exists:tms_instances,id',
        'name'            => 'sometimes|string|max:255',
    ];

    /**
     * @param       $model
     * @param array $data
     *
     * @return array
     */
    protected static function prepareUpdate($model, array $data): array
    {
        if (isset($data['directory_id']) && !is_null($model->getOriginal('directory_id'))) {
            unset($data['directory_id']);
        }

        return $data;
    }

    /**
     * @param $model
     */
    protected static function endUpdate($model): void
    {
        if (isset($model->xData['role_id']) && isset($model->xData['applications'])) {
            $companyApplicationRoles = ApplicationRole::where('role_id', $model->xData['role_id'])
                ->whereNotIn('application_id', array_filter($model->xData['applications']))
                ->where('company_id', $model->id)
                ->get();

            // Delete all company application roles
            foreach ($companyApplicationRoles as $companyApplicationRole) {
                $companyApplicationRole->delete();
            }

            // Attach company application roles which are not presented in global application roles
            foreach (array_filter($model->xData['applications']) as $applicationId) {
                $applicationRole = ApplicationRole::where('application_id', $applicationId)
                    ->where('role_id', $model->xData['role_id'])
                    ->where('company_id', $model->id)
                    ->first();

                if (!$applicationRole) {
                    ApplicationRole::create([
                        'application_id' => $applicationId,
                        'role_id'        => $model->xData['role_id'],
                        'company_id'     => $model->id,
                    ]);
                }
            }
        }
    }

    /**
     * @param $model
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected static function prepareDelete($model): void
    {
        // Delete role users of deleted company
        $roleUsers = RoleUser::where('company_id', $model->id)->get();

        foreach ($roleUsers as $roleUser) {
            $roleUser->delete();
        }

        // Delete application roles of deleted company
        $applicationRoles = ApplicationRole::where('company_id', $model->id)->get();

        foreach ($applicationRoles as $applicationRole) {
            $applicationRole->delete();
        }
    }

    /**
     * Get the related country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the related service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the related TMS instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tmsInstance()
    {
        return $this->belongsTo(TmsInstance::class);
    }

    /**
     * Get the related directory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function directory()
    {
        return $this->belongsTo(Directory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function faqs()
    {
        return $this->belongsToMany(Faq::class);
    }
}
