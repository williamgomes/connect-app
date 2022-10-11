@extends('web.layouts.app')

@section('title', __('Email:') . ' ' . $email->subject)

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item">
                            <a href="{{ action('Web\UserEmailController@index') }}">
                                {{ __('Emails') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $email->subject }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <header class="bg-dark pt-9 pb-11 d-none d-md-block">
        <div class="container-md">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="font-weight-bold text-white mb-2">
                        {{ $email->subject }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        #{{ $email->id }}
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ action('Web\UserEmailController@index') }}" class="btn btn-sm btn-gray-300-20" >
                        {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>
    </header>
    <main class="pb-8 pb-md-11 mt-md-n6">
        <div class="container-md">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-light-lg">
                        <div class="card-body">
                            <input type="hidden" id="email_data" value="{!! htmlentities($email->body) !!}"/>
                            <iframe width="100%" height="500" id="email_content" class="border-0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <section>
        <div class="container mb-10">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <hr class="border-gray-300 mb-8">
                    <h2>{{ __('Did you want help with something else?') }}</h2>
                </div>
                @include('web.help-center.all-categories')
            </div>
        </div>
    </section>
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

