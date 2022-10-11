<?php

namespace App\Http\Requests\App\Application;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ApplicationCreateRequest extends Request
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
            'name'            => ['required', 'string', 'max:255',
                Rule::unique('applications')->where(function ($query) {
                    return $query->where('directory_id', $this->directory_id);
                }),
            ],
            'onelogin_app_id' => ['required', 'integer', 'max:255',
                Rule::unique('applications')->where(function ($query) {
                    return $query->where('directory_id', $this->directory_id);
                }),
            ],
            'sso'             => 'required|boolean',
            'provisioning'    => 'required|boolean',
            'signup_url'      => 'sometimes|nullable|string|url',
        ];
    }
}
