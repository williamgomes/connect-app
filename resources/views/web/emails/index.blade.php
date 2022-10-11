@extends('web.layouts.app')

@section('title', __('Emails'))

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ __('Emails') }}
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
                        {{ __('Email Overview') }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        {{ __('Keep track of your emails.')}}
                    </p>
                </div>
            </div>
        </div>
    </header>
    <main class="pb-8 pb-md-11 mt-md-n6">
        <div class="container-md">
            <div class="row">
                <div class="col-12">
                    <div class="card card-bleed shadow-light-lg mb-6">
                        <form method="POST">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="mb-0">
                                            {{ __('Your Emails') }}
                                        </h4>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-xs btn-secondary-soft" id="select_all">{{ __('Select All') }}</a>
                                        <button class="btn btn-xs btn-primary" formaction="{{ action('Web\UserEmailController@markAsRead') }}">{{ __('Mark as Read') }}</button>
                                        <button class="btn btn-xs btn-primary" formaction="{{ action('Web\UserEmailController@markAsUnread') }}">{{ __('Mark as Unread') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group list-group-flush">
                                @forelse($emails as $email)
                                    <div class="p-5 {{ $email->read ? 'bg-gray-200' : '' }}">
                                        <div class="row align-items-center vertical-align">
                                            <div class="col-1" style="max-width:30px">
                                                <div class="custom-control custom-checkbox table-checkbox">
                                                    <input type="checkbox" class="custom-control-input email-checkbox" name="emails[]" id="{{ $email->id }}" value="{{ $email->id }}">
                                                    <label class="custom-control-label" for="{{ $email->id }}">&nbsp;</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <p class="mb-0 {{ $email->read ? '' : 'font-weight-bold' }}">
                                                    <a href="{{ action('Web\UserEmailController@show', $email) }}">
                                                        {{ $email->subject }}
                                                    </a>
                                                    <small class="text-gray-700 d-block">
                                                        {{ $email->created_at }}
                                                    </small>
                                                </p>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ action('Web\UserEmailController@show', $email) }}" class="btn btn-xs btn-outline-white">
                                                    {{ __('Show Email') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <i class=text-muted>{{ __('No incoming emails yet') }}</i>
                                @endforelse
                            </div>

                            <div class="row justify-content-center pagination-sm">
                                {{ $emails->appends(request()->query())->links() }}
                            </div>
                        </form>
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
    <script>
        let allSelected = true;
        let selectAllButton = $('#select_all');

        selectAllButton.on('click', function () {
            $('.email-checkbox').each(function () {
                $(this).prop('checked', allSelected);
            });

            allSelected = !allSelected;

            selectAllButton.text(allSelected ? '{{ __('Select All') }}' : '{{ __('Deselect All') }}');
        });
    </script>
@append