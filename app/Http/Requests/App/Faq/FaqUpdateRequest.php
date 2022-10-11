<?php

namespace App\Http\Requests\App\Faq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqUpdateRequest extends FormRequest
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
        $faq = $this->route()->parameter('faq');
        $category = $this->route()->parameter('faqCategory');

        return [
            'title'   => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('faq')->where(function ($query) use ($category) {
                    return $query->where('category_id', $category->id);
                })->ignore($faq->id),
            ],
            'content' => 'sometimes|string',
            'active'  => 'sometimes|boolean',
        ];
    }
}
