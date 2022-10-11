@extends('app.layouts.app')

@section('title', __('View Email'))

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\UserController@index') }}">{{ __('Users') }}</a> /
                        <a href="{{ action('App\UserController@show', $user) }}">{{ $user->name }}</a>/
                        <a href="{{ action('App\UserEmailController@index', $user) }}">{{ __('Emails') }}</a>/
                        {{ $email->subject }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Emails') }}
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="{{ action('App\UserEmailController@index', [$user, $email]) }}" class="btn btn-primary">
                        {{ __('Back') }}
                    </a>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs nav-overflow header-tabs">
                        <li class="nav-item">
                            <a href="{{ action('App\UserController@show', $user->id) }}" class="nav-link active">
                                {{ __('Overview') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <input type="hidden" id="email_data" value="{!! htmlentities($email->body) !!}"/>
            <iframe width="100%" height="500" id="email_content" class="border-0"></iframe>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            let context = $('#email_content')[0].contentWindow.document;
            let body = $('body', context);
            body.html($('#email_data').val());
        });
    </script>
@append