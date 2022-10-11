<div class="form-group">
    @php
        $id = $id ?? str_replace('.', '_', $name);
    @endphp
    @isset($label)
        <label for="{{ $id }}">
            {{ $label }}
            @if (isset($options) && strpos($options, 'required') !== false)
                <small class="text-muted">({{ __('Required') }})</small>
            @endif
        </label>
    @endisset

    @isset ($prepend)
        {{ $prepend }}
    @endisset

    <select class="form-control
        {{ isset($class) ? $class : '' }}
        {{ $errors->has($name) ? ' is-invalid' : '' }}"
        name="{{ $name }}"
        {{ isset($style) ? '' : 'data-toggle=select' }}
        data-options='{"theme": "max-results-5"}'
        id="{{ $id }}"
        {{ isset($options) ? $options : '' }} >

        @if (!(isset($options) && strpos($options, 'required') !== false))
            <option value="" selected></option>
        @endif

        @if (!(isset($options) && strpos($options, 'required') !== false))
            <option value="">-</option>
        @endif

        @foreach($array as $key => $value)
            <option value="{{ $key }}" {{ (old($name, $attributes['value'] ?? null) == $key) ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>

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

    {{-- Init Select for Livewire --}}
    @if (isset($options) && preg_match('/wire:model\=([\w\.]+)/', $options))
        <x-forms.livewire.select :options="$options" :id="$id" />
    @endif
</div>
