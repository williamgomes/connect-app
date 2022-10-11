<?php

namespace App\Http\Requests\App\Role;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class RoleCreateRequest extends Request
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
            'directory_id' => 'required|integer|exists:directories,id',
            'name'         => ['required', 'string', 'max:255',
                Rule::unique('roles')->where(function ($query) {
                    return $query->where('directory_id', $this->directory_id);
                }),
            ],
        ];
    }
}
