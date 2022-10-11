@extends('app.layouts.app')

@section('title', __('Account settings'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Account') }} /
                        {{ __('Settings') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Settings') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-auto">
            @include('app.users.partials.profile-picture')
        </div>
        <div class="col">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <label>{{ __('Name') }}</label>
                        <input class="form-control" value="{{ $user->name }}" disabled>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <label>{{ __('Email Address') }}</label>
                        <input class="form-control" value="{{ $user->email }}" disabled>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="form-group">
                        <label>{{ __('Phone Number') }}</label>
                        <input class="form-control" value="{{ $user->phone_number ?? '-' }}" disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <hr class="mt-3 mb-4">

            <form method="POST" action="{{ action('App\SettingsController@update') }}">
                @csrf
                {{-- Blog Notifications --}}
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="hidden" name="blog_notifications" value="0"/>
                        <input type="checkbox" class="custom-control-input{{ $errors->has('blog_notifications') ? ' is-invalid' : '' }}" id="blog_notifications" value="1" name="blog_notifications" {{ old('blog_notifications', $user->blog_notifications) ? 'checked' : ''}}>
                        <label class="custom-control-label" for="blog_notifications">{{ __('Blog Notifications') }}</label>
                    </div>
                    @if ($errors->has('blog_notifications'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('blog_notifications') }}</strong>
                        </span>
                    @endif
                </div>

                <hr class="my-4">
                <button type="submit" class="btn btn-block btn-primary">
                    {{ __('Save settings') }}
                </button>
            </form>
        </div>
    </div>
@endsection
