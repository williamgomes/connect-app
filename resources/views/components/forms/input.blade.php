<div class="form-group">
    @isset($label)
        <label>
            {{ $label }}
            @if (isset($options) && strpos($options, 'required') !== false)
                <small class="text-muted">({{ __('Required') }})</small>
            @endif
        </label>
    @endisset

    @isset ($prepend)
        {{ $prepend }}
    @endisset

    <input id="{{ $id ?? $name }}"
    type="{{ $type }}"
    class="form-control
    {{ isset($class) ? $class : '' }}
    {{ $errors->has($name) ? 'is-invalid' : '' }}"
    name="{{ $name }}"
    value="{{ isset($value) ? old($name, $value) : old($name) }}"
    placeholder="{{ isset($placeholder) ? $placeholder : (__('Enter') . ' ' . strtolower($label)) }}"
    {{ isset($options) ? $options : '' }} />

    @isset ($append)
        {{ $append }}
    @endisset

    @if(isset($description))
        <span class="feedback">
            <small class="text-muted">{{ $description }}</small>
        </span>
    @endif

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
