<?php

namespace App\Http\Requests\App\ReportBudget;

use App\Http\Requests\Request;

class ReportBudgetUpdateRequest extends Request
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
            'budget_values'   => 'required|array',
            'budget_values.*' => 'sometimes|nullable|integer',
        ];
    }
}
