<div class="form-group">
    @php
        $id = $id ?? str_replace('.', '_', $name);
    @endphp
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

    <input id="{{ $id }}"
    type="text" 
    class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" 
    name="{{ $name }}" 
    value="{{ old($name, $value ?? '') }}" 
    placeholder="{{ isset($placeholder) ? $placeholder : (__('Enter') . ' ' . strtolower($label)) }}" 
    {{ isset($options) ? $options : '' }} />

    @isset ($append)
        {{ $append }}
    @endisset

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>

@push('script')
    <script type="text/javascript">
        $("#{{ $id }}").flatpickr({
            allowInput: true,
            time_24hr: true,
            enableTime: true,
            dateFormat: "Y-m-d H:i"
        });
    </script>
@endpush
