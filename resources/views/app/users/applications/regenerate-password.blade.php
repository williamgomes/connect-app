@extends('app.layouts.app')

@section('title', 'Re-generate password')

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\UserController@index') }}">{{ __('Users') }}</a> /
                        <a href="{{ action('App\UserController@show', $user) }}">{{ $user->name }}</a> /
                        <a href="{{ action('App\UserController@show', $user) }}">{{ __('Applications') }}</a> /
                        {{ $application->name }} /
                        {{ __('Re-generate password') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Re-generate password') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\ApplicationUserController@regeneratePassword', [$user, $application]) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Length') }}</label>

            <input id="length" type="number" class="form-control {{ $errors->has('length') ? 'is-invalid' : '' }}"
                   name="length" value="{{ old('length') }}" placeholder="Enter length" required autofocus>

            @if ($errors->has('length'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('length') }}</strong>
                </span>
            @endif
        </div>

        <div class="custom-control custom-checkbox checklist-control">
            <input type="hidden" class="hidden-checkbox" name="upper_case"/>
            <input class="custom-control-input character-type-checkbox" id="upper_case"
                   type="checkbox" {{ old('upper_case', 1) ? 'checked' : '' }}/>
            <label class="custom-control-label" for="upper_case">{{ __('Uppercase') }}</label>
            <small class="text-muted ml-3 mt-1">
                {!! __('Check if you want new password contain <code class="text-black-50 text-decoration-underline">ABCDEFGHIJKLMNOPQRSTUVWXYZ</code> characters') !!}
            </small>
        </div>

        <div class="custom-control custom-checkbox checklist-control">
            <input type="hidden" class="hidden-checkbox" name="lower_case"/>
            <input class="custom-control-input character-type-checkbox" id="lower_case"
                   type="checkbox" {{ old('lower_case', 1) ? 'checked' : '' }}/>
            <label class="custom-control-label" for="lower_case">{{ __('Lowercase') }}</label>
            <small class="text-muted ml-3 mt-1">
                {!! __('Check if you want new password contain <code class="text-black-50 text-decoration-underline">abcdefghijklmnopqrstuvwxyz</code> characters') !!}
            </small>
        </div>

        <div class="custom-control custom-checkbox checklist-control">
            <input type="hidden" class="hidden-checkbox" name="numbers"/>
            <input class="custom-control-input character-type-checkbox" id="numbers"
                   type="checkbox" {{ old('numbers', 1) ? 'checked' : '' }}/>
            <label class="custom-control-label" for="numbers">{{ __('Numbers') }}</label>
            <small class="text-muted ml-3 mt-1">
                {!! __('Check if you want new password contain <code class="text-black-50 text-decoration-underline">1234567890</code> characters') !!}
            </small>
        </div>

        <div class="custom-control custom-checkbox checklist-control">
            <input type="hidden" class="hidden-checkbox" name="special_symbols"/>
            <input class="custom-control-input character-type-checkbox" id="special_symbols"
                   type="checkbox" {{ old('special_symbols', 1) ? 'checked' : '' }}/>
            <label class="custom-control-label" for="special_symbols">{{ __('Special Symbols') }}</label>
            <small class="text-muted ml-3 mt-1">
                {!! __('Check if you want new password contain <code class="text-black-50 text-decoration-underline">#%-</code> characters') !!}
            </small>
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Re-generate password') }}
        </button>

        <a href="{{ action('App\UserController@show', $user) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel re-generation') }}
        </a>
    </form>
@endsection
@section('script')
    <script>
        $('.character-type-checkbox').change(function () {
            if ($('.character-type-checkbox:checked').length === 0) {
                $(this).prop('checked', true);
            }
        });

        $('form').one("submit", function (e) {
            e.preventDefault();
            let checkboxes = $('[type=checkbox]');

            // Prepare data in proper structure before form submit
            $.each(checkboxes, function (index, element) {
                let checkbox = $(element);
                checkbox.siblings('.hidden-checkbox').val(checkbox.is(":checked") ? 1 : 0);
            });

            $(this).submit();
        });
    </script>
@append
