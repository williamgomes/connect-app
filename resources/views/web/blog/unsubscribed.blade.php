@extends('web.layouts.app')

@section('title', 'Unsubscribed')

@section('content')
    <header class="bg-dark pt-9 pb-11 d-none d-md-block">
        <div class="container-md">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="font-weight-bold text-white mb-2">
                        {{ __('We\'re sorry to see you go!') }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        {{ $user->email }} {{ __(' email have been unsubscribed from blog notifications. You can always subscribe back to blog notifications via the Settings page')}}.
                    </p>
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="container mb-10">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <hr class="border-gray-300 mb-8">
                    <h2>{{ __('Do you require any help?') }}</h2>
                </div>
                @include('web.help-center.all-categories')
            </div>
        </div>
    </section>
@endsection
