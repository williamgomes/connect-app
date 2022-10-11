<div class="form-group">
    @isset ($prepend)
        {{ $prepend }}
    @endisset

    <div class="custom-control custom-switch">
        <input name="{{ $name }}" value="0" hidden>
        <input id="{{ $name }}" name="{{ $name }}" type="checkbox" value="1" {{ old($name, isset($value) ? $value : null) == true ? 'checked' : '' }} class="custom-control-input"
        {{ isset($options) ? $options : '' }} />

        @isset($label)
            <label class="custom-control-label" for="{{ $name }}">{{ $label }}</label>
        @endisset

        @if(isset($description))
            <small class="text-muted ml-3">
                {{ $description }}
            </small>
        @endif
    </div>

    @isset ($append)
        {{ $append }}
    @endisset

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
