<?php

namespace App\Http\Requests\App\Ticket;

use App\Http\Requests\Request;
use App\Models\Category;
use App\Models\CategoryField;
use App\Models\Country;
use App\Models\Service;
use Illuminate\Validation\Rule;

class TicketCreateRequest extends Request
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
        $fieldsRules = [];
        $category = Category::find($this->category_id);

        if ($category) {
            foreach ($category->fields as $field) {
                if ($field->required) {
                    $fieldsRules[$field->slug][] = 'required';
                } else {
                    $fieldsRules[$field->slug][] = 'sometimes';
                    $fieldsRules[$field->slug][] = 'nullable';
                }

                if (!empty($field->min)) {
                    $fieldsRules[$field->slug][] = 'min:' . $field->min;
                }

                if (!empty($field->max)) {
                    $fieldsRules[$field->slug][] = 'max:' . $field->max;
                }

                if ($field->type == CategoryField::TYPE_ATTACHMENT) {
                    $fieldsRules[$field->slug][] = 'file';
                } elseif (in_array($field->type, [CategoryField::TYPE_INPUT, CategoryField::TYPE_TEXT, CategoryField::TYPE_DROPDOWN])) {
                    $fieldsRules[$field->slug][] = 'string';
                } elseif ($field->type == CategoryField::TYPE_NUMBER) {
                    $fieldsRules[$field->slug][] = 'numeric';
                } elseif ($field->type == CategoryField::TYPE_MULTIPLE) {
                    $fieldsRules[$field->slug][] = 'array';

                    if ($field->required) {
                        $fieldsRules[$field->slug . '.*'][] = 'required';
                    } else {
                        $fieldsRules[$field->slug . '.*'][] = 'sometimes';
                        $fieldsRules[$field->slug . '.*'][] = 'nullable';
                    }
                }
            }
        }

        return array_merge([
            'priority_id'    => 'required|integer|exists:ticket_priorities,id',
            'user_id'        => 'sometimes|integer|nullable|exists:users,id',
            'requester_id'   => 'sometimes|integer|exists:users,id',
            'category_id'    => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('active', Category::IS_ACTIVE),
            ],
            'subcategory_id' => [
                'sometimes',
                'nullable',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('active', Category::IS_ACTIVE),
            ],
            'service_id'     => [
                'required',
                'integer',
                Rule::exists('services', 'id')
                    ->where('active', Service::IS_ACTIVE),
            ],
            'country_id'     => [
                'required',
                'integer',
                Rule::exists('countries', 'id')
                    ->where('active', Country::IS_ACTIVE),
            ],
            'title'          => 'required|string|max:255',
            'comment'        => (!count($fieldsRules) ? 'required' : 'sometimes|nullable') . '|string',
            'attachments'    => 'sometimes|array',
            'attachments.*'  => 'sometimes|file',
        ], $fieldsRules);
    }
}
