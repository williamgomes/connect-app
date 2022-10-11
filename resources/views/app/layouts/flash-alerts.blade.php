{{-- Success --}}
@if (session('success'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                <strong>{{ __('Success!') }}</strong> {{ session('success') }}
            </div>
        </div>
    </div>
@endif

{{-- Info --}}
@if (session('info'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info" role="alert">
                {{ session('info') }}
            </div>
        </div>
    </div>
@endif

{{-- Warning --}}
@if (session('warning'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                {{ session('warning') }}
            </div>
        </div>
    </div>
@endif

{{-- Error --}}
@if (session('error'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                <strong>{{ __('Error!') }}</strong> {{ session('error') }}
            </div>
        </div>
    </div>
@endif

{{-- Errors --}}
@if ($errors->any())
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    <div><strong>{{ __('Error!') }}</strong> {{ $error }}</div>
                @endforeach
            </div>
        </div>
    </div>
@endif
