@extends('web.layouts.app')

@section('title', 'Help Center')

@section('content')
    <section data-jarallax data-speed=".8" class="pt-10 pb-11 py-md-12 overlay overlay-black overlay-80 jarallax" style="background-image: url({{ asset('web/images/covers/cover-1.jpg') }});">
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
                    <h2>{{ __('What can we help with?') }}</h2>
                    @include('web.layouts.flash-alerts')
                </div>
                @include('web.help-center.all-categories')
            </div>
        </div>
    </section>
@endsection
