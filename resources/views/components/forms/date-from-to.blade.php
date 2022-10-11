<div class="form-group">
    @isset($label)
        <label>
            {{ $label }}
        </label>
    @endisset

    <div class="row">
        <div class="col-6">
            <input id="{{ $fromId ?? 'from_' . $name }}"
            type="text" 
            class="form-control {{ $errors->has('from_' . $name) ? 'is-invalid' : '' }}" 
            name="{{ 'from_' . $name }}" 
            value="{{ old('from_' . $name, $fromValue ?? '') }}" 
            placeholder="{{ __('From') }}" 
            {{ isset($fromOptions) ? $fromOptions : '' }} />

            @if ($errors->has('from_' . $name))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('from_' . $name) }}</strong>
                </span>
            @endif
        </div>

        <div class="col-6">
            <input id="{{ $toId ?? 'to_' . $name }}"
            type="text" 
            class="form-control {{ $errors->has('to_' . $name) ? 'is-invalid' : '' }}" 
            name="{{ 'to_' . $name }}" 
            value="{{ old('to_' . $name, $toValue ?? '') }}" 
            placeholder="{{ __('To') }}" 
            {{ isset($toOptions) ? $toOptions : '' }} />

            @if ($errors->has('to_' . $name))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('to_' . $name) }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

@push('script')
    <script type="text/javascript">
        $("#{{ 'from_' . $name }}").flatpickr({
            allowInput: true,
        });

        $("#{{ 'to_' . $name }}").flatpickr({
            allowInput: true,
        });
    </script>
@endpush
