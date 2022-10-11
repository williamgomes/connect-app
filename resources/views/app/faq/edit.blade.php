@extends('app.layouts.app')

@section('title', __('Edit FAQ'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\FaqCategoryController@index') }}">{{ __('FAQ Categories') }}</a>
                        @isset($faq->category)
                            @include('app.faq.categories.breadcrumbs', ['faqCategory' => $faq->category]) /
                            <a href="{{ action('App\FaqCategoryController@show', $faq->category) }}">{{ __('FAQ') }}</a>
                        @endisset /
                        {{ $faq->title }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit') . ' ' . $faq->title }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form id="form" class="mb-4" role="form" method="POST" action="{{ action('App\FaqController@update', [$faq->category, $faq]) }}">
        @csrf

        <div class="form-group">
            <label for="title">{{ __('Title') }}</label>
            <input type="text" class="form-control {{ $errors->has('title') ? ' invalid' : '' }}" name="title" id="title" value="{{ old('title', $faq->title) }}">

            @if ($errors->has('title'))
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="content">{{ __('Content') }}</label>
            <textarea name="content" class="content-editor {{ $errors->has('content') ? ' invalid' : '' }}" id="content">{!! old('content', $faq->content) !!}</textarea>

            @if ($errors->has('content'))
                <div class="invalid-feedback">
                    {{ $errors->first('content') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Author') }}</label>

            <select class="form-control" data-toggle="select" name="user_id" id="user_id">
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ $faq->user_id == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('user_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="active" value="0"/>
                <input type="checkbox" class="custom-control-input" value="1" id="active" name="active" {{ old('active', $faq->active) ? 'checked' : '' }}>
                <label class="custom-control-label" for="active">{{ __('Active') }}</label>
            </div>

            @if ($errors->has('active'))
                <div class="invalid-feedback">
                    {{ $errors->first('active') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Users') }}</label> <small class="text-muted">({{ __('who will have access') }})</small>
            <select class="form-control" data-toggle="select" name="users[]" id="users" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ collect(old('users', $faq->users()->pluck('users.id')))->contains($user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('users'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('users') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Companies') }}</label> <small class="text-muted">({{ __('who will have access') }})</small>
            <select class="form-control" data-toggle="select" name="companies[]" id="companies" multiple>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ collect(old('companies', $faq->companies()->pluck('companies.id')))->contains($company->id) ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('companies'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('companies') }}</strong>
                </span>
            @endif
        </div>
        
        <hr class="my-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update FAQ') }}
        </button>

        <a href="{{ action('App\FaqCategoryController@show', $faq->category) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel Update') }}
        </a>
    </form>
@endsection

@section('script')
    @include('app.layouts.editor-script', ['path' => 'faq'])
@append
