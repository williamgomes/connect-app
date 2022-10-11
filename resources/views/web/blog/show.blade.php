@extends('web.layouts.app')

@section('title', 'Blog')

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item">
                            <a href="{{ action('Web\BlogController@index') }}" class="text-gray-700">
                                {{ __('Blog') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $blogPost->title }}
                        </li>
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
                        {{ $blogPost->title }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        {{ $blogPost->category }}
                    </p>
                </div>
            </div>
        </div>
    </header>
    <section class="mt-n6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card card-row shadow-light-lg mb-6">
                        <div class="row no-gutters">
                            <div class="col-12 order-md-1">
                                <a class="card-body pb-5 pt-7" href="#!">
                                    <p class="mb-0">
                                        {!! $blogPost->content !!}
                                    </p>
                                </a>

                                <div class="card-meta">
                                    <hr class="card-meta-divider">

                                    <h6 class="text-uppercase text-muted mb-0">
                                        {{ $blogPost->user->name }}
                                    </h6>
                                    <h6 class="text-uppercase text-muted mb-0 ml-auto">
                                        <time class="ml-4" datetime="{{ $blogPost->created_at }}">{{ \App\Helpers\TimeHelper::blogFormattedDate($blogPost->created_at) }}</time>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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


