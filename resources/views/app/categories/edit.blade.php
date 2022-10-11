@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $category->name)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\CategoryController@index') }}">{{ __('Categories') }}</a> /
                        {{ $category->name }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit category') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $category)
                        <form role="form" method="POST" action="{{ action('App\CategoryController@destroy', $category) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete category') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\CategoryController@update', $category) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Parent Category') }}</label>

            <select class="form-control" data-toggle="select" data-options='{"theme": "max-results-5", "allowClear": true, "placeholder": "{{ __('No parent category') }}"}' name="parent_id" id="parent_id" {{ $category->subcategories()->count() ? 'disabled' : '' }}>
                <option></option>
                @foreach($primaryCategories as $primaryCategory)
                    <option value="{{ $primaryCategory->id }}" {{ (old('parent_id', $category->parent_id) == $primaryCategory->id) ? ' selected' : '' }}>{{ $primaryCategory->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('parent_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('parent_id') }}</strong>
                </span>
            @endif
            @if($category->subcategories()->count())
                <small class="text-info">{{ __('A parent category can\'t be selected as category has subcategories.') }}</small>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $category->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('User') }}</label>

            <select class="form-control" data-toggle="select" name="user_id" id="user_id">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $category->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('user_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('SLA Hours') }}</label>

            <input id="sla_hours" type="number" class="form-control {{ $errors->has('sla_hours') ? 'is-invalid' : '' }}" name="sla_hours" value="{{ old('sla_hours', $category->sla_hours) }}" placeholder="{{ __('Enter SLA hours') }}" required>

            @if ($errors->has('sla_hours'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sla_hours') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="hidden" name="active" value="0"/>
                <input type="checkbox" class="custom-control-input" value="1" id="active" name="active" {{ old('active', $category->active) ? 'checked' : '' }}>
                <label class="custom-control-label" for="active">{{ __('Active') }}</label>
            </div>

            @if ($errors->has('active'))
                <div class="invalid-feedback">
                    {{ $errors->first('active') }}
                </div>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update category') }}
        </button>

        <a href="{{ action('App\CategoryController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>
    </form>

    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-header-title">
                        {{ __('Fields') }}
                    </h4>
                </div>
                <div class="col-auto">
                    @can('create', \App\Models\CategoryField::class)
                        <a href="{{ action('App\CategoryFieldController@create', $category) }}" class="btn btn-sm btn-primary">{{ __('Add Field') }}</a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-nowrap card-table">
                <thead>
                <tr>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Required') }}</th>
                    <th class="text-right">
                        {{ __('Actions') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($category->fields as $field)
                    <tr>
                        <td>
                            {{ ucfirst($field->type) }}
                        </td>
                        <td>
                            {{ $field->title }}
                        </td>
                        <td>
                            @if ($field->required)
                                <span class="text-success">●</span>
                                {{ __('Yes') }}
                            @else
                                <span class="text-danger">●</span>
                                {{ __('No') }}
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="dropdown">
                                <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @can('update', $field)
                                        <a href="{{ action('App\CategoryFieldController@edit', [$category, $field]) }}" class="dropdown-item">
                                            {{ __('Edit') }}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
