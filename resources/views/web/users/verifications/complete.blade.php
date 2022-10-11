@extends('web.layouts.app')

@section('title', 'Verify your identity')

@section('content')
    <section data-jarallax data-speed=".8" class="pt-10 pb-11 py-md-14 overlay overlay-black overlay-80 jarallax" style="background-image: url({{ asset('web/images/covers/cover-3.jpg') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 text-center">
                    <h1 class="display-2 font-weight-bold text-white">
                        {{ __("You're almost there!")}}
                    </h1>
                    <p class="lead text-white-75 mb-0">
                        {{ __("You have now verified your email. Now it's time for your phone.")}}
                        <br>
                        {{ __('Please fill in the SMS code below.')}}
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
                    <h2>{{ __('Verify your phone') }}</h2>
                </div>
                <div class="col-12 col-md-6">
                    @include('web.layouts.flash-alerts')
                    <form method="POST" action="{{ action('UserVerificationController@update', $userVerification->email_token) }}">
                        @csrf

                        <div class="form-group">
                            <label for="sms_token">
                                {{ __('SMS Code') }}
                            </label>
                            <input id="phone_token" type="number" step="1" min="10000" max="99999" class="form-control{{ $errors->has('sms_token') ? ' is-invalid' : '' }}" name="sms_token" value="{{ old('sms_token') }}" placeholder="{{ __('Enter the SMS code we sent you') }}" required autofocus>

                            <span class="feedback">
                                <small class="text-muted">{{ __("Please enter the 5-digit code we sent to your phone.")}}</small>
                            </span>

                            @if ($errors->has('sms_token'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('sms_token') }}</strong>
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
