@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $company->name . ' ' . __('roles'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\CompanyController@index') }}">{{ __('Companies') }}</a> /
                        <a href="{{ action('App\CompanyController@show', $company) }}">{{ $company->name }}</a> /
                        <a href="{{ action('App\CompanyController@show', $company) }}">{{ __('Roles') }}</a> /
                        {{ $role->name }} /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit') }} {{ $role->name }} {{ __('access') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\CompanyController@updateRole', [$company, $role]) }}">
        @csrf

        <h4 class="mt-5 mb-4">{{ __('Applications') }}</h4>
        @foreach($applications as $application)
            <div class="model mt-4">
                <div class="custom-control custom-checkbox checklist-control">
                    <input type="hidden" class="hidden-checkbox" name="applications[]"/>
                    <input class="custom-control-input application-checkbox" data-id="{{ $application->id }}" id="{{ $application->id }}" type="checkbox"
                        {{ collect(old('applications', $applicationIds))->contains($application->id) ? 'checked' : '' }}/>
                    <label class="custom-control-label" for="{{ $application->id }}">{{ $application->name }}
                        <small class="badge badge-soft-secondary ml-1">{{ collect(old('applications', $rootApplicationIds))->contains($application->id) ? __('enabled globally') : '' }}</small>
                    </label>
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
                }
            });

            $(this).submit();
        });
    </script>
@endsection
