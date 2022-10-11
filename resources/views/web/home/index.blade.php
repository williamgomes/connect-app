@extends('web.layouts.app')

@section('title', 'Help Center')

@section('content')
    <section data-jarallax data-speed=".8" class="pt-10 pb-11 py-md-10 overlay overlay-black overlay-80 jarallax" style="background-image: url({{ asset('web/images/covers/cover-1.jpg') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 text-center">
                    <h1 class="display-2 font-weight-bold text-white">
                        {{ __("Let's get you connected!")}}
                    </h1>
                    <p class="lead text-white-75 mb-0">
                        {{ __("We're here to help you stay connected to our internal Synega Applications, so you can focus on what you're awesome at!")}}
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
            <div class="row">
                <div class="col-12 text-center mt-8 mb-4">
                    <h2>{{ __('Please verify your identity to continue') }}</h2>
                    <p class="text-muted">{{ __('Please select one of the two methods below to verify your identity and login to Connect.')}}</p>
                    @include('web.layouts.flash-alerts')
                </div>
                <div class="col-12 col-md-6">
                    <div class="card card-border border-dark shadow-lg mb-6 mb-md-8 mb-lg-0 lift lift-lg">
                        <div class="card-body text-center">
                            <div class="icon-circle bg-dark text-white mb-5">
                                <i class="fe fe-lock"></i>
                            </div>

                            <h4 class="font-weight-bold">
                                {{ __('OneLogin')}}
                            </h4>

                            <p class="text-gray-700 mb-5">
                                {{ __('Authenticate yourself via OneLogin. This is the fastest way to access our Help Desk.')}}
                            </p>

                            <a href="{{ url('/saml2/' . (\App\Models\Directory::first()->slug ?? '') . '/login') }}" class="btn btn-primary btn-xs mb-1">
                                {{ __('Select') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card card-border border-dark shadow-lg mb-6 mb-md-8 mb-lg-0 lift lift-lg">
                        <div class="card-body text-center">
                            <div class="icon-circle bg-danger text-white mb-5">
                                <i class="fe fe-x-circle"></i>
                            </div>

                            <h4 class="font-weight-bold">
                                {{ __('Manual Identification')}}
                            </h4>

                            <p class="text-gray-700 mb-5">
                                {{ __("Can't get into OneLogin? Please use this method in order to get your issue resolved.")}}
                            </p>

                            <a href="{{ action('UserVerificationController@create') }}" class="btn btn-primary btn-xs mb-1">
                                {{ __('Select') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
