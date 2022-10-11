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
                        {{ __('Forgot your password?') }}
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="email">
                                        {{ __('Email Address') }}
                                    </label>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('login') }}" class="form-text small text-muted">
                                        {{ __('Go back to login') }}
                                    </a>
                                </div>
                            </div>

                            <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter your email address') }}" required autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button class="btn btn-block btn-primary" type="submit">
                            {{ __('Send Password Reset Link') }}
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
