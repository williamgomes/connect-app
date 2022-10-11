<div class="form-group">
    @isset($label)
        <label>
            {{ $label }}
        </label>
    @endisset

    <div class="row">
        @foreach($array as $key => $value)
            <div class="col-md-6">
                <div class="custom-control custom-switch my-2">
                    <input value="{{ $key }}"
                           id="{{ $name . '_' . $key }}"
                           name="{{ $name }}[]"
                           type="checkbox"
                           class="custom-control-input"
                           {{ in_array($key, old($name, isset($values) ? $values->toArray() : [])) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="{{ $name . '_' . $key }}">
                        {{ $value }}
                    </label>
                </div>
            </div>
        @endforeach

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
</div>