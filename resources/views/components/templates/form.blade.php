<form class="mb-4" method="{{ $method }}" action="{{ $methodAction }}" {{ $options ?? '' }}>
    @csrf

    {{ $slot }}

    @if (!isset($attributes['hr']))
        <hr class="mt-5 mb-5">
    @endif

    <button type="submit" class="btn btn-block btn-primary">
        {{ $name }}
    </button>
    
    @isset($cancelAction)
        <a href="{{ $cancelAction }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel') }}
        </a>
    @endisset
</form>
