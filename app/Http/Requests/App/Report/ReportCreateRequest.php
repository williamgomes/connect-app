<?php

namespace App\Http\Requests\App\Report;

use App\Http\Requests\Request;

class ReportCreateRequest extends Request
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
            'metabase_id' => 'required|integer',
            'folder_id'   => 'required|integer|exists:report_folders,id',
            'title'       => 'required|string|max:255|unique:reports,title',
            'description' => 'sometimes|nullable|string',
        ];
    }
}
