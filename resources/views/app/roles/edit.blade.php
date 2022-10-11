@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $role->name)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\RoleController@index') }}">{{ __('Roles') }}</a> /
                        {{ $role->name }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit role') }}
                    </h1>
                </div>
                <div class="col-auto">
                    @can('delete', $role)
                        <form role="form" method="POST" action="{{ action('App\RoleController@destroy', $role) }}">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-outline-danger" type="submit">{{ __('Delete role') }}</button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\RoleController@update', $role) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Directory') }}</label>

            @if($role->directory)
                <input type="text" class="form-control text-muted" value="{{ $role->directory->name }}" readonly>
            @else
                <select class="form-control" data-toggle="select" name="directory_id" id="directory_id">
                    @foreach($directories as $directory)
                        <option value="{{ $directory->id }}" {{ old('directory_id', $role->directory_id) == $directory->id ? 'selected' : '' }}>{{ $directory->name }}</option>
                    @endforeach
                </select>
            @endif

            @if ($errors->has('directory_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('directory_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $role->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>


        <h4 class="mt-5 mb-4">{{ __('Applications') }}</h4>
        @foreach($applications as $application)
            <div class="model mt-4">
                <div class="custom-control custom-checkbox checklist-control">
                    <input type="hidden" class="hidden-checkbox" name="applications[]"/>
                    <input class="custom-control-input application-checkbox" data-id="{{ $application->id }}" id="{{ $application->id }}" type="checkbox" {{ collect(old('applications', $role->applications()->whereNull('company_id')->pluck('application_id')))->contains($application->id) ? 'checked' : '' }}/>
                    <label class="custom-control-label" for="{{ $application->id }}">{{ $application->name }}</label>
                </div>
            </div>
        @endforeach

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update role') }}
        </button>

        <a href="{{ action('App\RoleController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>
    </form>
@endsection

@section('script')
    <script>
        $('form').one("submit", function (e) {
            e.preventDefault();
            let checkboxes = $('[type=checkbox]');

            // Prepare data in proper structure before form submit
            $.each(checkboxes, function (index, element) {
                let checkbox = $(element);
                if (checkbox.is(":checked")) {
                    checkbox.siblings('.hidden-checkbox').val(checkbox.attr('data-id'));
                    console.log(checkbox.attr('data-id'));
                }
            });

            $(this).submit();
        });
    </script>
@endsection
