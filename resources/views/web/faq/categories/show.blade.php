@extends('web.layouts.app')

@section('title', 'FAQ')

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item">
                            <a href="{{ action('Web\FaqCategoryController@index') }}" class="text-gray-700">
                                {{ __('FAQ') }}
                            </a>
                        </li>
                        @include('web.faq.categories.breadcrumbs', $faqCategory)
                    </ol>
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <header class="bg-dark pt-9 pb-11 d-none d-md-block">
        <div class="container-md">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="font-weight-bold text-white mb-2">
                        {{ $faqCategory->name }}
                    </h1>
                </div>
            </div>
        </div>
    </header>

    <div class="mt-n10 container dropdown-menu-container">
        <livewire:faq.search/>
    </div>

    @includeWhen($faqCategories->count(), 'web.faq.categories.show-all')

    @includeWhen($faqs->count(), 'web.faq.show-all')

    <section>
        <div class="container mb-10">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <hr class="border-gray-300 mb-8">
                    <h2>{{ __('Did you want help with something else?') }}</h2>
                </div>
                @include('web.help-center.all-categories')
            </div>
        </div>
    </section>
@endsection
