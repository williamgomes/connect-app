@extends('web.layouts.auth')

@section('content')
    <section class="section-border border-primary">
        <div class="container d-flex flex-column">
            <div class="row align-items-center justify-content-center no-gutters min-vh-100">
                <div class="col-12">
                    <h1 class="display-3 font-weight-bold text-center">
                        {{ __('Verify Your Email Address') }}
                    </h1>

                    @if (session('resent'))
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 col-md-6">
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <p class="mb-5 text-center text-muted">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                    </p>

                    <form action="{{ route('verification.resend') }}" method="POST">
                        @csrf
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Re-send verification email')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
