<?php

namespace App\Http\Requests\App\Application;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ApplicationUpdateRequest extends Request
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
        $application = $this->route()->parameter('application');

        return [
            'directory_id' => 'sometimes|integer|exists:directories,id',
            'name'         => ['sometimes', 'string', 'max:255',
                Rule::unique('applications')->where(function ($query) {
                    return $query->where('directory_id', $this->directory_id);
                })->ignore($application->id),
            ],
            'sso'          => 'sometimes|boolean',
            'provisioning' => 'sometimes|boolean',
            'signup_url'   => 'sometimes|nullable|string|url',
        ];
    }
}
