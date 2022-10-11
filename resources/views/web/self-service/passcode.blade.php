@extends('web.layouts.app')

@section('title', 'New Passcode')

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item">
                            <a href="{{ action('Web\HelpCenterController@index') }}" class="text-gray-700">
                                {{ __('Help Center') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Self-Service') }}
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ __('New Passcode') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <header class="bg-dark pt-9 pb-11 d-none d-md-block">
        <div class="container-md">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="font-weight-bold text-white mb-2">
                        {{ __('Generate a temporary DUO Mobile passcode') }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        {{ __('Are you having phone trouble? Please confirm below to request a temporary login token to your phone number.')}}
                    </p>
                </div>
            </div>
        </div>
    </header>
    <main class="pb-8 pb-md-11 mt-md-n6">
        <div class="container-md">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-light-lg">
                        <div class="card-body">
                            @include('web.layouts.flash-alerts')
                            <form method="POST" action="{{ action('Web\SelfServiceController@storePasscode') }}">
                                <div class="row">
                                    @csrf

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>
                                                {{ __('Directory') }}
                                                <small class="text-muted">({{ __('Required') }})</small>
                                            </label>

                                            <select class="form-control" name="directory_id" id="directory_id">
                                                <option disabled selected>{{ __('Select Directory')}}</option>
                                                @foreach(auth()->user()->directories as $directory)
                                                    <option value="{{ $directory->id }}" {{ old('directory_id') ? 'selected' : '' }}>
                                                        {{ $directory->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('directory_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('directory_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Hours --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('How many hours does the temporary passcode need to work?') }}</label>
                                            <input type="number" min=1 max=48 class="form-control {{ $errors->has('hours') ? 'is-invalid' : '' }}"
                                                   name="hours" value="{{ old('hours') }}" placeholder="{{ __('Enter hours') }}" required autofocus>

                                            @if ($errors->has('hours'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('hours') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Confirmation --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __("Can you confirm that this is just temporary? If it's not, please contact us to help you setup DUO Mobile again.") }}</label>
                                            <input type="text" class="form-control {{ $errors->has('confirmation') ? 'is-invalid' : '' }}"
                                                   name="confirmation" placeholder="{{ __('Type "YES" to confirm') }}" required>

                                            @if ($errors->has('confirmation'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <span class="text-muted">
                                            {{ __('Please note: We will send this the passcode to be used with DUO Mobile to your mobile phone via SMS.') }}
                                        </span>
                                    </div>

                                    <div class="col-12 mt-4 col-md-auto">
                                        <button class="btn btn-block btn-primary" type="submit">
                                            {{ __('Get temporary passcode on SMS') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <section>
        <div class="container mb-10">
            <div class="row">

                <div class="col-12 text-center mb-4">
                    <hr class="border-gray-300 mb-8">
                    <h2>{{ __('Did you want help with something else?') }}</h2>
                </div>
                @include('web.help-center.all-categories')
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $('.dragupload input').change(function () {
            $(this).siblings('span').text(this.files.length + " files selected");
        });
    </script>
@append
