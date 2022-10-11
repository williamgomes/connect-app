@extends('app.layouts.app')

@section('title', $faqCategory->name . ' ' . 'FAQ Category')

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\FaqCategoryController@index') }}">{{ __('FAQ Categories') }}</a>
                        @include('app.faq.categories.breadcrumbs', $faqCategory)
                    </h6>
                    <h1 class="header-title">
                        {{ __('FAQ category') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can ('update', $faqCategory)
                        <a href="{{ action('App\FaqCategoryController@edit', $faqCategory) }}" class="btn btn-primary">{{ __('Edit FAQ Category') }}</a>
                    @endcan
                    @can ('create', \App\Models\FaqCategory::class)
                        <a href="{{ action('App\FaqCategoryController@create', ['category_id' => $faqCategory]) }}" class="btn btn-primary">{{ __('Create FAQ Category') }}</a>
                    @endcan
                    @can ('create', \App\Models\Faq::class)
                        <a href="{{ action('App\FaqController@create', $faqCategory) }}" class="btn btn-primary">{{ __('Create FAQ') }}</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        @include('app.faq.categories.show-all', $faqCategory)
    </div>

    <div class="card">
        @if($faqs->count())
            <div class="table-responsive">
                <table class="table card-table table-sm table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px;"></th>
                            <th>
                                {{ __('Title') }}
                            </th>
                            <th>
                                {{ __('Author') }}
                            </th>
                            <th>
                                {{ __('Active') }}
                            </th>
                            <th class="text-right">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="sortable sortable-faq">
                        @foreach ($faqs as $faq)
                            <tr data-id="{{ $faq->id }}">
                                <td>
                                    @can('sort', \App\Models\Faq::class)
                                        <span class="fe fe-maximize-2 mr-2"></span>
                                    @endcan
                                </td>
                                <td>
                                    <a href="{{ action('App\FaqController@edit', [$faqCategory, $faq]) }}">{{ $faq->title }}</a>
                                </td>
                                <td>
                                    <a href="{{ action('App\UserController@show', $faq->user) }}">{{ $faq->user->name }}</a>
                                </td>
                                <td>
                                    @if ($faq->active)
                                        <span class="text-success">●</span>
                                        {{ __('Yes') }}
                                    @else
                                        <span class="text-danger">●</span>
                                        {{ __('No') }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fe fe-more-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{ action('App\FaqController@edit', [$faqCategory, $faq]) }}" class="dropdown-item">{{ __('Edit') }}</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card-body text-center">
                <i class="text-muted">{{ __('No FAQ') }}</i>
            </div>
        @endif
    </div>
@endsection

@can('sort', \App\Models\Faq::class)
    @include('app.faq.sortable-script', ['type' => 'faq', 'url' => action('Ajax\FaqController@sort')])
@endcan