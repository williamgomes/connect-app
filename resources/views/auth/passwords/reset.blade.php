@extends('web.layouts.auth')

@section('content')
    <section>
        <div class="container d-flex flex-column">
            <div class="row align-items-center justify-content-center no-gutters min-vh-100">
                <div class="col-12 col-md-6 col-lg-4 py-8 py-md-11">
                    <h1 class="mb-0 font-weight-bold">
                        {{ __('Reset password') }}
                    </h1>

                    <p class="mb-6 text-muted">
                        {{ __("Let's get you back on track") }}.
                    </p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

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
                            {{ __('Reset password') }}
                        </button>
                    </form>
                </div>
                <div class="col-lg-7 offset-lg-1 align-self-stretch d-none d-lg-block">
                    <div class="h-100 w-cover bg-cover" style="background-image: url({{ asset('/web/images/login/auth-side-cover.jpg') }});"></div>

                    <div class="shape shape-left shape-fluid-y svg-shim text-white">
                        <svg viewBox="0 0 100 1544" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h100v386l-50 772v386H0V0z" fill="currentColor"/></svg>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
