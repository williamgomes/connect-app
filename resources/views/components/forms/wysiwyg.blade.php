<div class="form-group{{ $errors->has($name) ? ' is-invalid' : '' }}">
    @isset($label)
        <label>
            {{ $label }}
            @if (isset($options) && strpos($options, 'required') !== false)
                <small class="text-muted">({{ __('Required') }})</small>
            @endif
        </label>
    @endisset
    <textarea class="wysiwyg{{ isset($withImage) && $withImage ? '-with-img' : '' }} {{ isset($class) ? $class : '' }}" name="{{ $name }}" id="{{ $id ?? $name }}" {{ isset($options) ? $options : '' }} >{{ isset($value) ? old($name, $value) : old($name) }}</textarea>

    @if ($errors->has($name))
        <span class="text-danger" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
