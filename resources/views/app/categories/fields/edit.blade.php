@extends('app.layouts.app')

@section('title', __('Edit Field'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\CategoryController@index') }}">{{ __('Categories') }}</a> /
                        <a href="{{ action('App\CategoryController@edit', $category) }}">{{ $category->name }}</a> /
                        <a href="{{ action('App\CategoryController@edit', $category) }}">{{ __('Fields') }}</a> /
                        {{ $categoryField->title }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit Field') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $categoryField)
                        <form role="form" method="POST" action="{{ action('App\CategoryFieldController@destroy', [$category, $categoryField]) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Remove Field') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\CategoryFieldController@update', [$category, $categoryField]) }}">
        @csrf
        
        <div class="form-group">
            <label>{{ __('Type') }}</label>

            <select class="form-control" data-toggle="select" name="type" id="type">
                @foreach(\App\Models\CategoryField::$types as $key => $value)
                    <option value="{{ $key }}" {{ $categoryField->type == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>

            @if ($errors->has('type'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Title') }}</label>

            <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title', $categoryField->title) }}" placeholder="{{ __('Enter title') }}" required autofocus>

            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Description') }}</label>

            <textarea id="description" type="text" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" placeholder="{{ __('Enter description') }}">{{ old('description', $categoryField->description) }}</textarea>

            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group {{ in_array(old('type', $categoryField->type), [\App\Models\CategoryField::TYPE_ATTACHMENT]) ? 'd-none' : '' }}">
            <label>{{ __('Placeholder') }}</label>

            <input id="placeholder" type="text" class="form-control {{ $errors->has('placeholder') ? 'is-invalid' : '' }}" name="placeholder" value="{{ old('placeholder', $categoryField->placeholder) }}" placeholder="{{ __('Enter placeholder') }}">

            @if ($errors->has('placeholder'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('placeholder') }}</strong>
                </span>
            @endif
        </div>

        <div id="options" class="form-group {{ in_array(old('type', $categoryField->type), [\App\Models\CategoryField::TYPE_DROPDOWN, \App\Models\CategoryField::TYPE_MULTIPLE]) ? '' : 'd-none' }}">
            <label>{{ __('Options') }}</label>

            @foreach(old('options', $categoryField->options ?? ['']) as $option)
                <div class="option-blocks row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control  mb-3" name="options[]" value="{{ $option }}" placeholder="{{ __('Enter option') }}"/>
                            </div>
                            <div class="col-auto">
                                <input type="hidden" name="active" value="0"/>
                                <input class="default-options mt-3" type="radio" name="default_value" value="{{ $option }}" {{ $option == $categoryField->default_value ? 'checked' : '' }}> <span>{{ __('Default') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-danger btn-sm mt-2 float-right remove-option">{{ __('Remove') }}</a>
                    </div>
                </div>
            @endforeach

            <button id="addMore" class="btn btn-primary btn-sm mt-1 d-block">{{ __('Add more') }}</button>
        </div>

        <div class="form-group {{ in_array(old('type', $categoryField->type), [\App\Models\CategoryField::TYPE_ATTACHMENT, \App\Models\CategoryField::TYPE_DROPDOWN, \App\Models\CategoryField::TYPE_MULTIPLE]) ? 'd-none' : '' }}">
            <label>{{ __('Default Value') }}</label>

            <textarea id="defaultValue" type="text" class="form-control {{ $errors->has('default_value') ? 'is-invalid' : '' }}" name="default_value" placeholder="{{ __('Enter default value') }}">{{ old('default_value', $categoryField->default_value) }}</textarea>

            @if ($errors->has('default_value'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('default_value') }}</strong>
                </span>
            @endif
        </div>

        <div id="minMaxBlock" class="{{ in_array(old('type', $categoryField->type), [ \App\Models\CategoryField::TYPE_INPUT, \App\Models\CategoryField::TYPE_NUMBER ]) ? '' : 'd-none' }}">
            <div class="form-group">
                <label>{{ __('Min') }}</label>

                <input id="min" type="text" class="form-control {{ $errors->has('min') ? 'is-invalid' : '' }}" name="min" value="{{ old('min', $categoryField->min) }}" placeholder="{{ __('Enter min') }}">

                @if ($errors->has('min'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('min') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label>{{ __('Max') }}</label>

                <input id="max" type="text" class="form-control {{ $errors->has('max') ? 'is-invalid' : '' }}" name="max" value="{{ old('max', $categoryField->max) }}" placeholder="{{ __('Enter max') }}">

                @if ($errors->has('max'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('max') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="required" value="0"/>
                <input type="checkbox" class="custom-control-input" value="1" id="required" name="required" {{ old('required', $categoryField->required) ? 'checked' : '' }}>
                <label class="custom-control-label" for="required">{{ __('Required') }}</label>
            </div>

            @if ($errors->has('required'))
                <div class="invalid-feedback">
                    {{ $errors->first('required') }}
                </div>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update Field') }}
        </button>

        <a href="{{ action('App\CategoryController@edit', $category) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>
    </form>
@endsection

@include('app.categories.fields.script')