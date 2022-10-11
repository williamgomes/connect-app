<?php

namespace App\Http\Requests\App\Company;

use App\Http\Requests\Request;
use App\Models\Country;
use App\Models\Service;
use Illuminate\Validation\Rule;

class CompanyCreateRequest extends Request
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
        return [
            'directory_id'    => 'required|integer|exists:directories,id',
            'country_id'      => [
                'required',
                'integer',
                Rule::exists('countries', 'id')
                    ->where('active', Country::IS_ACTIVE),
                Rule::unique('companies')->where(function ($query) {
                    return $query->where('service_id', $this->service_id)
                        ->where('directory_id', $this->directory_id);
                }),
            ],
            'service_id'      => [
                'required',
                'integer',
                Rule::exists('services', 'id')
                    ->where('active', Service::IS_ACTIVE),
            ],
            'tms_instance_id' => 'sometimes|nullable|integer|exists:tms_instances,id',
            'name'            => 'required|string|max:255',
        ];
    }
}
