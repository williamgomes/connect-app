@extends('web.layouts.app')

@section('title', 'FAQ')

@section('content')
    <header class="bg-dark pt-9 pb-11 d-none d-md-block">
        <div class="container-md">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="font-weight-bold text-white mb-2">
                        {{ __('FAQ') }}
                    </h1>
                </div>
            </div>
        </div>
    </header>

    <div class="mt-n10 container dropdown-menu-container">
        <livewire:faq.search/>
    </div>

    @include('web.faq.categories.show-all')

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

