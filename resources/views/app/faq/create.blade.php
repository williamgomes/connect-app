@extends('app.layouts.app')

@section('title', __('Create FAQ'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col-md-12">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\FaqCategoryController@index') }}">{{ __('FAQ Categories') }}</a>
                        @isset($faqCategory)
                            @include('app.faq.categories.breadcrumbs', $faqCategory) /
                            <a href="{{ action('App\FaqCategoryController@show', $faqCategory) }}">{{ __('FAQ') }}</a>
                        @endisset /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create FAQ') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form id="form" class="mb-4" role="form" method="POST" action="{{ action('App\FaqController@store', $faqCategory) }}">
        @csrf

        <div class="form-group">
            <label for="title">{{ __('Title') }}</label>
            <input type="text" class="form-control {{ $errors->has('title') ? ' invalid' : '' }}" name="title" id="title" value="{{ old('title') }}">

            @if ($errors->has('title'))
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="content">{{ __('Content') }}</label>
            <textarea name="content" class="content-editor {{ $errors->has('content') ? ' invalid' : '' }}" id="content">{{ old('content') }}</textarea>

            @if ($errors->has('content'))
                <div class="invalid-feedback">
                    {{ $errors->first('content') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="active" value="0"/>
                <input type="checkbox" class="custom-control-input" value="1" id="active" name="active" {{ old('active', 1) ? 'checked' : '' }}>
                <label class="custom-control-label" for="active">{{ __('Active') }}</label>
            </div>

            @if ($errors->has('active'))
                <div class="invalid-feedback">
                    {{ $errors->first('active') }}
                </div>
            @endif
        </div>

        <hr class="my-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create FAQ') }}
        </button>

        <a href="{{ action('App\FaqCategoryController@show', $faqCategory) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Creation') }}
        </a>
    </form>
@endsection

@section('script')
    @include('app.layouts.editor-script', ['path' => 'faq'])
@append
