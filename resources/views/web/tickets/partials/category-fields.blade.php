@foreach($category->fields as $field)
    <div class="mb-4 form-group{{ $errors->has($field->slug) ? ' has-error' : '' }}">
        <label>
            {{ $field->title }}

            @if($field->required)
                <small class="text-muted">({{ __('Required') }})</small>
            @endif
        </label>

        @if($field->type == \App\Models\CategoryField::TYPE_ATTACHMENT)
            <x-forms.upload-drag-and-drop :name="$field->slug"/>
        @elseif($field->type == \App\Models\CategoryField::TYPE_INPUT || $field->type == \App\Models\CategoryField::TYPE_NUMBER)
            <input type="{{ $field->type == \App\Models\CategoryField::TYPE_INPUT ? 'text' : 'number' }}" class="form-control {{ $errors->has($field->slug) ? 'is-invalid' : '' }}"
                   name="{{ $field->slug }}" value="{{ $old[$field->slug] ?? null }}" placeholder="{{ $field->placeholder ?? __('Enter ' . $field->title) }}" {{ $field->required ? 'required' : '' }}>
        @elseif($field->type == \App\Models\CategoryField::TYPE_TEXT)
            <textarea type="text" class="form-control {{ $errors->has($field->slug) ? 'is-invalid' : '' }}"
                      name="{{ $field->slug }}" placeholder="{{ $field->placeholder ?? __('Enter ' . $field->title) }}" {{ $field->required ? 'required' : '' }}>{{ $old[$field->slug] ?? null }}</textarea>
        @elseif($field->type == \App\Models\CategoryField::TYPE_DROPDOWN || $field->type == \App\Models\CategoryField::TYPE_MULTIPLE)
            @foreach($field->options as $option)
                <div class="my-1">
                    <label for="{{ $field->slug }}" class="small"><input class="mr-2" type="{{ $field->type == \App\Models\CategoryField::TYPE_DROPDOWN ? 'radio' : 'checkbox' }}" name="{{ $field->slug }}{{ $field->type == \App\Models\CategoryField::TYPE_DROPDOWN ? '' : '[]' }}" value="{{ $option }}" {{ isset($old[$field->slug]) && ((is_array($old[$field->slug]) && in_array($option, $old[$field->slug])) || ($old[$field->slug] == $option)) ? 'checked' : '' }}>{{ $option }}</label>
                </div>
            @endforeach
        @endif

        @if($field->description)
            <small class="text-info">{{ $field->description }}</small>
        @endif
    </div>
@endforeach