@extends('app.layouts.app')

@section('title', __('Create blog post'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\BlogPostController@index') }}">{{ __('Blog posts') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create blog post') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\BlogPostController@store') }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Title') }}</label>

            <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title') }}" placeholder="{{ __('Enter title') }}" required autofocus>

            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Category') }}</label>

            <input id="category" type="text" class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category" value="{{ old('category') }}" placeholder="{{ __('Enter category') }}" required>

            @if ($errors->has('category'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('category') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
            <textarea class="content-editor" name="content">{!! old('content') !!}</textarea>

            @if ($errors->has('content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif
        </div>

        <input value="{{ \App\Models\BlogPost::STATUS_VISIBLE }}" hidden>
        {{-- <select class="form-control" data-toggle="select" name="status" id="status">
            <option value="{{ \App\Models\BlogPost::STATUS_VISIBLE }}" {{ (old('status') == \App\Models\BlogPost::STATUS_VISIBLE) ? ' selected' : '' }}>
                {{ __('Visible') }}
            </option>
            <option value="{{ \App\Models\BlogPost::STATUS_DRAFT }}" {{ (old('status') == \App\Models\BlogPost::STATUS_DRAFT) ? ' selected' : '' }}>
                {{ __('Draft') }}
            </option>
        </select> --}}

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create blog post') }}
        </button>

        <a href="{{ action('App\BlogPostController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection

@section('script')
    @include('app.layouts.editor-script', ['path' => 'blog'])
@append
