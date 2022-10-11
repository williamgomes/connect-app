@extends('web.layouts.app')

@section('title', 'Verify your identity')

@section('content')
    <section data-jarallax data-speed=".8" class="pt-10 pb-11 py-md-14 overlay overlay-black overlay-80 jarallax" style="background-image: url({{ asset('web/images/covers/cover-2.jpg') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 text-center">
                    <h1 class="display-2 font-weight-bold text-white">
                        {{ __("Let's get you verified!")}}
                    </h1>
                    <p class="lead text-white-75 mb-0">
                        {{ __("Before we can help you, we need to know that you're who you say you are.")}}
                        <br>
                        {{ __('Please fill out the form below.')}}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <div class="position-relative">
        <div class="shape shape-bottom shape-fluid-x svg-shim text-light">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="currentColor"/></svg>
        </div>
    </div>

    <section>
        <div class="container mb-10">
            <div class="row justify-content-center">
                <div class="col-12 text-center mt-8 mb-4">
                    <h2>{{ __('Verify your identity') }}</h2>
                </div>
                <div class="col-12 col-md-6">
                    @include('web.layouts.flash-alerts')
                    <form method="POST" action="{{ action('UserVerificationController@store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="synega_id">
                                {{ __('Synega ID') }}
                            </label>
                            <input id="synega_id" type="text" class="form-control{{ $errors->has('synega_id') ? ' is-invalid' : '' }}" name="synega_id" value="{{ old('synega_id') }}" placeholder="{{ __('Enter your Synega ID') }}" required autofocus>

                            @if ($errors->has('synega_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('synega_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        <hr>

                        <button class="btn btn-block btn-primary" type="submit">
                            {{ __('Verify') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
