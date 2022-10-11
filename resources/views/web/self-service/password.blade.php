@extends('web.layouts.app')

@section('title', 'New Password')

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
                            {{ __('New Password') }}
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
                        {{ __('Create a new password') }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        {{ __('Fill out the form below to reset your password to something of your choice.')}}
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
                            <form method="POST" action="{{ action('Web\SelfServiceController@storePassword') }}">
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

                                    {{-- Password Information --}}
                                    <div class="col-12">
                                        <div class="card bg-light border">
                                            <div class="card-body">
                                                <p class="mb-2">
                                                    {{ __('Password Requirements') }}
                                                </p>

                                                <p class="small text-muted mb-2">
                                                    {{ __('To create a new password, you have to meet all of the following requirements:') }}
                                                </p>

                                                <ul class="small text-muted pl-4 mb-0">
                                                    <li>
                                                        {{ __('Minimum 12 characters, Maximum 64 characters') }}
                                                    </li>
                                                    <li>
                                                        {{ __('At least one uppercase characters (A – Z)') }}
                                                    </li>
                                                    <li>
                                                        {{ __('At least one lowercase characters (a – z)') }}
                                                    </li>
                                                    <li>
                                                        {{ __('At least one special character') }}
                                                    </li>
                                                    <li>
                                                        {{ __('At least one number') }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Password --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('Password') }}</label>
                                            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                   name="password" placeholder="{{ __('Enter password') }}" required autofocus>

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Password --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('Password Confirmation') }}</label>
                                            <input type="password" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                                   name="password_confirmation" placeholder="{{ __('Enter password again') }}" required>

                                            @if ($errors->has('password_confirmation'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4 col-md-auto">
                                        <button class="btn btn-block btn-primary" type="submit">
                                            {{ __('Update password') }}
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

