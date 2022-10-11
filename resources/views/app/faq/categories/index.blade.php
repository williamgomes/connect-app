@extends('app.layouts.app')

@section('title', __('FAQ Categories'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('FAQ Categories') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('FAQ Categories') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can ('create', \App\Models\FaqCategory::class)
                        <a href="{{ action('App\FaqCategoryController@create') }}" class="btn btn-primary">{{ __('Create FAQ Category') }}</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        @include('app.faq.categories.show-all')
    </div>
@endsection
