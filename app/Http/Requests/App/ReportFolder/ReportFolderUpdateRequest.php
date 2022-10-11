<?php

namespace App\Http\Requests\App\ReportFolder;

use App\Http\Requests\Request;

class ReportFolderUpdateRequest extends Request
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
            'parent_id' => 'sometimes|nullable|integer|exists:report_folders,id',
            'user_id'   => 'sometimes|integer|exists:users,id',
            'name'      => 'sometimes|string|max:255',
        ];
    }
}
