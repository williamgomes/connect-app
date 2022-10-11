@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $guide->title)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\GuideController@index') }}">{{ __('Guides') }}</a> /
                        {{ $guide->title }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Guide') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $guide)
                        <form role="form" method="POST" action="{{ action('App\GuideController@destroy', $guide) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete Guide') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\GuideController@update', $guide) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Title') }}</label>

            <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title', $guide->title) }}" placeholder="{{ __('Enter title') }}" required autofocus>

            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
            <textarea class="content-editor" name="content">{!! old('content', $guide->content) !!}</textarea>

            @if ($errors->has('content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Inventories') }}</label>
            <select class="form-control" data-toggle="select" name="inventories[]" id="inventories" multiple>
                @foreach($inventories as $inventory)
                    <option value="{{ $inventory->id }}" {{ collect(old('inventories', $guide->inventories->pluck('id')))->contains($inventory->id) ? 'selected' : '' }}>{{ $inventory->identifier }}</option>
                @endforeach
            </select>

            @if ($errors->has('inventories'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('inventories') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Guide') }}
        </button>
        
        <a href="{{ action('App\GuideController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>
    </form>
@endsection

@section('script')
    @include('app.layouts.editor-script', ['path' => 'guides'])
@append
