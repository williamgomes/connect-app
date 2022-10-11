<?php

namespace App\Http\Requests\App\Datacenter;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class DatacenterUpdateRequest extends Request
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
        $datacenter = $this->route()->parameter('datacenter');

        return [
            'name'        => 'sometimes|string|max:255|unique:datacenters,name, ' . $datacenter->id,
            'country'     => 'sometimes|string|min:2|max:2',
            'location'    => 'sometimes|string|min:3|max:3',
            'location_id' => ['sometimes', 'integer', 'min:1',
                Rule::unique('datacenters')->where(function ($query) {
                    return $query->where('country', $this->country)
                        ->where('location', $this->location);
                })->ignore($datacenter->id), ],
            'note'        => 'sometimes|nullable|string|max:1000',
        ];
    }
}
