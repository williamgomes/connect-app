<?php

namespace App\Http\Requests\App\Report;

use App\Http\Requests\Request;

class ReportUpdateRequest extends Request
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
        $report = $this->route()->parameter('report');

        return [
            'metabase_id' => 'sometimes|integer',
            'folder_id'   => 'sometimes|integer|exists:report_folders,id',
            'title'       => 'sometimes|string|max:255|unique:reports,title,' . $report->id,
            'description' => 'sometimes|nullable|string',
            'users'       => 'sometimes|nullable|array',
            'users.*'     => 'sometimes|nullable|integer|exists:users,id',
        ];
    }
}
