@extends('web.layouts.app')

@section('title', 'New Phone')

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item">
                            <a href="{{ action('Web\HelpCenterController@index') }}" class="text-gray-700">
                                {{ __('Help Center') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Self-Service') }}
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ __('New Phone') }}
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
                        {{ __('Activate DUO Mobile on a new phone') }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        {{ __('Have you changed phone, or simply need to activate DUO Mobile again? Fill out the form below.')}}
                    </p>
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
                            @include('web.layouts.flash-alerts')
                            <form method="POST" action="{{ action('Web\SelfServiceController@storePhone') }}">
                                <div class="row">
                                    @csrf

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>
                                                {{ __('Directory') }}
                                                <small class="text-muted">({{ __('Required') }})</small>
                                            </label>

                                            <select class="form-control" name="directory_id" id="directory_id">
                                                <option disabled selected>{{ __('Select Directory')}}</option>
                                                @foreach(auth()->user()->directories as $directory)
                                                    <option value="{{ $directory->id }}" {{ old('directory_id') ? 'selected' : '' }}>
                                                        {{ $directory->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('directory_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('directory_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    {{-- Confirmation --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('Please confirm that you are aware that your current DUO Mobile login will be deactivated.') }}</label>
                                            <input type="text" class="form-control {{ $errors->has('confirmation') ? 'is-invalid' : '' }}"
                                                   name="confirmation" placeholder="{{ __('Type "YES" to confirm') }}" required>

                                            @if ($errors->has('confirmation'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <span class="text-muted">
                                            {{ __('Please note: DUO Mobile will send you an email with information on how to setup DUO Mobile on your phone.') }}
                                        </span>
                                    </div>

                                    <div class="col-12 mt-4 col-md-auto">
                                        <button class="btn btn-block btn-primary" type="submit">
                                            {{ __('Activate DUO Mobile on a new phone') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

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
        $('.dragupload input').change(function () {
            $(this).siblings('span').text(this.files.length + " files selected");
        });
    </script>
@append
