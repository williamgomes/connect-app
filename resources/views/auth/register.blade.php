@extends('web.layouts.auth')

@section('content')
    <section>
        <div class="container d-flex flex-column">
            <div class="row align-items-center justify-content-center no-gutters min-vh-100">
                <div class="col-12 col-md-6 col-lg-4 py-8 py-md-11">
                    <h1 class="mb-0 font-weight-bold">
                        {{ __('Sign up') }}
                    </h1>

                    <p class="mb-6 text-muted">
                        {{ __("Let's get you started") }}.
                    </p>

                    <form class="mb-6" method="POST" action="{{ route('register') }}">
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

                        <div class="form-group">
                            <label for="first_name">
                                {{ __('First Name') }}
                            </label>
                            <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" placeholder="{{ __('Enter your first name') }}" required>

                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="last_name">
                                {{ __('Last Name') }}
                            </label>
                            <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="{{ __('Enter your last name') }}" required>

                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">
                                {{ __('Email Address') }}
                            </label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter your email address') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="phone_number">
                                {{ __('Phone Number') }}
                            </label>
                            <input id="phone_number" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" placeholder="{{ __('Enter your phone number') }}" required>

                            @if ($errors->has('phone_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">
                                {{ __('Password') }}
                            </label>
                            <input id="password" type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="{{ __('Enter your password') }}" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-5">
                            <label for="password-confirm">
                                {{ __('Password Confirmation') }}
                            </label>
                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Enter your password again') }}" required>
                        </div>

                        <button class="btn btn-block btn-primary" type="submit">
                            {{ __('Sign up') }}
                        </button>
                    </form>

                    <p class="mb-0 font-size-sm text-muted">
                        {{ __('Already have an account?') }}
                        <a href="{{ route('login') }}">
                            {{ __('Login') }}.
                        </a>
                    </p>
                </div>
                <div class="col-lg-7 offset-lg-1 align-self-stretch d-none d-lg-block">

                    <!-- Image -->
                    <div class="h-100 w-cover bg-cover" style="background-image: url({{ asset('/web/images/login/auth-side-cover.jpg') }});"></div>
                    
                    <!-- Shape -->
                    <div class="shape shape-left shape-fluid-y svg-shim text-white">
                        <svg viewBox="0 0 100 1544" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h100v386l-50 772v386H0V0z" fill="currentColor"/></svg>
                    </div>

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>
@endsection
