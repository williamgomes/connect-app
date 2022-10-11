<input type="hidden" name="{{ $name }}">
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
        data-toggle="select"
        multiple="multiple"
        data-options='{"theme": "max-results-5"}'
        name="{{ $name . '[]' }}"
        id="{{ $id }}"
        {{ isset($options) ? $options : '' }} >
        @foreach($array as $key => $value)
            <option value="{{ $key }}" {{ collect(old($name, $values ?? []))->contains($key) ? "selected" : "" }}>
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
