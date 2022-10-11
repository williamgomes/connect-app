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

    <div class="dragupload d-flex align-items-center justify-content-center">
        <input type="file" id="{{ $id ?? $name }}" name="{{ $name }}{{ (isset($options) && strpos($options, 'multiple') !== false) ? '[]' : '' }}" {{ isset($options) ? $options : '' }} />
        <span class="text-muted">{{ __('Drag your file(s) or click here to upload') }}</span>
    </div>

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

@push('script')
    <script type="text/javascript">
        $('#{{ $id ?? $name }}').change(function () {
            $(this).siblings('span').text(this.files.length + " " + "{{ __('file(s) selected')}}");
        });
    </script>
@endpush
