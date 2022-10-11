<?php

namespace App\Http\Requests\App\Company;

use App\Http\Requests\Request;
use App\Models\Country;
use App\Models\Service;
use Illuminate\Validation\Rule;

class CompanyUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $company = $this->route()->parameter('company');

        return [
            'directory_id'    => 'sometimes|integer|exists:directories,id',
            'country_id'      => [
                'sometimes',
                'integer',
                Rule::exists('countries', 'id')
                    ->where('active', Country::IS_ACTIVE),
                Rule::unique('companies')
                    ->ignore($company->id)
                    ->where(function ($query) use ($company) {
                        return $query->where('service_id', $this->service_id ?? $company->service_id)
                            ->where('directory_id', $this->directory_id ?? $company->directory_id);
                    }),
            ],
            'service_id'      => [
                'sometimes',
                'integer',
                Rule::exists('services', 'id')
                    ->where('active', Service::IS_ACTIVE),
            ],
            'tms_instance_id' => 'sometimes|nullable|integer|exists:tms_instances,id',
            'name'            => 'sometimes|string|max:255',
        ];
    }
}
