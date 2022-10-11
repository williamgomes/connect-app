@extends('app.layouts.app')

@section('title', __('Edit') . ' ' . $apiApplication->name)

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        {{ __('Settings') }} /
                        <a href="{{ action('App\ApiApplicationController@index') }}">{{ __('Applications') }}</a> /
                        <a href="{{ action('App\ApiApplicationController@show', $apiApplication) }}">{{ $apiApplication->name }}</a> /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit application') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ApiApplicationController@update', $apiApplication) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $apiApplication->name) }}" placeholder="{{ __('Enter name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <h4 class="mt-5 mb-4">{{ __('Models access') }}</h4>
        @foreach($modelAccesses as $modelAccess)
            <div class="model mt-4">
                <div class="custom-control custom-checkbox checklist-control">
                    <input type="hidden" class="hidden-checkbox" name="model_accesses[]"/>
                    <input class="custom-control-input model-access-checkbox" data-id="{{ $modelAccess->id }}" id="{{ $modelAccess->model }}" type="checkbox" {{ in_array($modelAccess->id, $apiApplicationModelAccesses) ? 'checked' : '' }}/>
                    <label class="custom-control-label" for="{{ $modelAccess->model }}">{{ $modelAccess->name }}</label>
                    <span class="text-muted ml-3">
                        {{ $modelAccess->description }}
                    </span>
                </div>

                <div class="model-access-abilities pl-4 mt-3">
                    @foreach($modelAccess->abilities as $ability)
                        <div class="custom-control custom-checkbox checklist-control">
                            <input type="hidden" class="hidden-checkbox" name="model_access_abilities[]"/>
                            <input class="custom-control-input model-access-ability-checkbox" data-id="{{ $ability->id }}" id="{{ $modelAccess->model }}_{{ $ability->ability }}" type="checkbox" {{ in_array($ability->id, $apiApplicationModelAccessAbilities) ? 'checked' : '' }}/>
                            <label class="custom-control-label" for="{{ $modelAccess->model }}_{{ $ability->ability }}">{{ $ability->name }}</label>
                            <span class="text-muted ml-3">
                                {{ $ability->description }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update application') }}
        </button>

        <a href="{{ action('App\ApiApplicationController@show', $apiApplication) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>
    </form>
@endsection

@section('script')
    <script>
        $('.model-access-checkbox').change(function () {
            let checkbox = $(this);
            let abilityCheckboxes = checkbox.closest('.model').find('.model-access-ability-checkbox');

            // Toggle ability checkboxes on model checkbox change
            $.each(abilityCheckboxes, function (index, element) {
                $(element).prop('checked', checkbox.is(":checked"));
            });
        });

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

