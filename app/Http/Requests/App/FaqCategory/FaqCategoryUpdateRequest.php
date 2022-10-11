<?php

namespace App\Http\Requests\App\FaqCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqCategoryUpdateRequest extends FormRequest
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
        $faqCategory = $this->route()->parameter('faqCategory');

        return [
            'category_id' => 'sometimes|nullable|integer|exists:faq_categories,id',
            'name'        => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('faq_categories')->where(function ($query) use ($faqCategory) {
                    return $query->where('category_id', $faqCategory->category_id);
                })->ignore($faqCategory->id),
            ],
        ];
    }
}
