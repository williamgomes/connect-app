<?php

namespace App\Http\Requests\App\Role;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends Request
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
        $role = $this->route()->parameter('role');

        return [
            'directory_id' => 'sometimes|integer|exists:directories,id',
            'name'         => ['sometimes', 'string', 'max:255',
                Rule::unique('roles')->where(function ($query) {
                    return $query->where('directory_id', $this->directory_id);
                })->ignore($role->id),
            ],
        ];
    }
}
