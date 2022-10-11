@extends('app.layouts.app')

@section('title', $user->name)

@section('breadcrumbs')
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\UserController@index') }}">{{ __('Users') }}</a> /
                        {{ $user->name }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Users') }}
                    </h1>
                </div>
                @can('update', $user)
                    <div class="col-auto">
                        <a href="{{ action('App\UserController@edit', $user) }}" class="btn btn-primary">
                            {{ __('Edit') }}
                        </a>
                    </div>
                @endcan
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-tabs nav-overflow header-tabs">
                        <li class="nav-item">
                            <a href="{{ action('App\UserController@show', $user) }}" class="nav-link active">
                                {{ __('Overview') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('App\UserController@tickets', $user) }}" class="nav-link">
                                {{ __('Tickets') }}
                            </a>
                        </li>
                        @can('viewEmails', $user)
                            <li class="nav-item">
                                <a href="{{ action('App\UserEmailController@index', $user) }}" class="nav-link">
                                    {{ __('Emails') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('Name') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted copy-to-clipboard copy-popover"
                               data-clipboard-text="{{ $user->name }}"
                               data-toggle="popover" data-placement="top" data-content="Copied!">
                            {{ $user->name }}
                        </small>
                    </div>
                </div>

                <hr>

                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('Role') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        @php
                            $role = '-';
                            if ($user->hasRole(\App\Models\User::ROLE_ADMIN)) {
                                $role = __('Administrator');
                            } elseif ($user->hasRole(\App\Models\User::ROLE_REGULAR)) {
                                $role = __('Regular');
                            } elseif ($user->hasRole(\App\Models\User::ROLE_DEVELOPER)) {
                                $role = __('Developer');
                            } elseif ($user->hasRole(\App\Models\User::ROLE_REPORTING)) {
                                $role = __('Reporting');
                            }
                        @endphp

                        <small class="text-muted copy-to-clipboard copy-popover" data-clipboard-text="{{ $role }}"
                               data-toggle="popover" data-placement="top" data-content="Copied!">
                            {{ $role }}
                        </small>
                    </div>
                </div>

                <hr>

                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('Default Username') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted copy-to-clipboard copy-popover"
                               data-clipboard-text="{{ $user->default_username }}"
                               data-toggle="popover" data-placement="top" data-content="Copied!">
                            {{ $user->default_username }}
                        </small>
                    </div>
                </div>

                <hr>

                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('Synega ID') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted copy-to-clipboard copy-popover"
                               data-clipboard-text="{{ $user->synega_id }}"
                               data-toggle="popover" data-placement="top" data-content="Copied!">
                            {{ $user->synega_id }}
                        </small>
                    </div>
                </div>

                <hr>

                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('UUID') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted copy-to-clipboard copy-popover"
                               data-clipboard-text="{{ $user->uuid }}"
                               data-toggle="popover" data-placement="top" data-content="Copied!">
                            {{ $user->uuid }}
                        </small>
                    </div>
                </div>

                @if($user->onelogin_id)
                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Onelogin ID') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted copy-to-clipboard copy-popover"
                                   data-clipboard-text="{{ $user->onelogin_id }}"
                                   data-toggle="popover" data-placement="top" data-content="Copied!">
                                {{ $user->onelogin_id }}
                            </small>
                        </div>
                    </div>
                @endif

                @if($user->duo_id)
                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Duo ID') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted copy-to-clipboard copy-popover"
                                   data-clipboard-text="{{ $user->duo_id }}"
                                   data-toggle="popover" data-placement="top" data-content="Copied!">
                                {{ $user->duo_id }}
                            </small>
                        </div>
                    </div>
                @endif

                <hr>

                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('Email') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted copy-to-clipboard copy-popover"
                               data-clipboard-text="{{ $user->email }}"
                               data-toggle="popover" data-placement="top" data-content="Copied!">
                            {{ $user->email }}
                        </small>
                    </div>
                </div>

                @if($user->phone_number)
                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Phone') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted copy-to-clipboard copy-popover"
                                   data-clipboard-text="{{ $user->phone_number }}"
                                   data-toggle="popover" data-placement="top" data-content="Copied!">
                                {{ $user->phone_number }}
                            </small>
                        </div>
                    </div>
                @endif

                <hr>

                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            {{ __('Blog Notifications') }}
                        </h5>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted">
                            @if($user->blog_notifications)
                                <span class="text-success">●</span>
                                {{ __('On') }}
                            @else
                                <span class="text-danger">●</span>
                                {{ __('Off') }}
                            @endif
                        </small>
                    </div>
                </div>

                @if($user->permissions->count())
                    <hr>

                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Permissions') }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">
                                @foreach($user->permissions as $permission)
                                    {{ $permission->name }}@if(!$loop->last),@endif
                                @endforeach
                            </small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-header-title">
                            {{ __('Roles') }}
                        </h4>
                    </div>
                    <div class="col-auto">
                        @can('create', \App\Models\RoleUser::class)
                            <a href="{{ action('App\RoleUserController@create', $user) }}" class="btn btn-sm btn-primary">
                                {{ __('Add role') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-nowrap card-table">
                    <thead>
                    <tr>
                        <th>
                            {{ __('Name') }}
                        </th>
                        <th>
                            {{ __('Company') }}
                        </th>
                        <th class="text-right">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    @foreach($roleUsers as $roleUser)
                        <tr>
                            <td>
                                @can('update', $roleUser->role)
                                    <a href="{{ action('App\RoleController@edit', $roleUser->role) }}">
                                        {{ $roleUser->role->name }}
                                    </a>
                                @else
                                    {{ $roleUser->role->name }}
                                @endcan
                            </td>
                            <td>
                                @can('update', $roleUser->company)
                                    <a href="{{ action('App\CompanyController@edit', $roleUser->company) }}">
                                        {{ $roleUser->company->name }}
                                    </a>
                                @else
                                    {{ $roleUser->company->name }}
                                @endcan
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('delete', $roleUser)
                                            <form action="{{ action('App\RoleUserController@destroy', $roleUser) }}" method="POST">
                                                @csrf
                                                {{ method_field('delete') }}
                                                <button class="dropdown-item delete-group">{{ __('Unassign') }}</button>
                                            </form>
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
    </div>
    <div class="col-12 col-xl-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col ml--2">
                        <h4 class="card-title mb-1">
                            {{ $user->name }}
                        </h4>
                        <p class="card-text small text-muted mb-1">
                            @if($user->hasRole(\App\Models\User::ROLE_ADMIN))
                                {{ __('Administrator') }}
                            @elseif($user->hasRole(\App\Models\User::ROLE_REGULAR))
                                {{ __('Regular') }}
                            @elseif($user->hasRole(\App\Models\User::ROLE_DEVELOPER))
                                {{ __('Developer') }}
                            @elseif($user->hasRole(\App\Models\User::ROLE_REPORTING))
                                {{ __('Reporting') }}
                            @else
                                -
                            @endif
                        </p>
                        <p class="card-text small">
                            @if($user->active)
                                <span class="text-success">●</span>
                                {{ __('Active') }}
                            @else
                                <span class="text-danger">●</span>
                                {{ __('Deactivated') }}
                            @endif
                        </p>
                    </div>
                    @can('update', $user)
                        <div class="col-auto">
                            <a href="{{ action('App\UserController@edit', $user) }}" class="btn btn-sm btn-primary d-none d-md-inline-block">
                                {{ __('Edit') }}
                            </a>
                        </div>
                    @endcan
                    <div class="col-auto">
                        <div class="dropdown">
                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ action('App\UserController@edit', $user) }}" class="dropdown-item">
                                    {{ __('Edit') }}
                                </a>
                                <form action="{{ $user->active ? action('App\UserController@deactivate', $user) : action('App\UserController@activate', $user) }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item">
                                            {{ $user->active ? __('Deactivate') : __('Activate') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('viewAny', \App\Models\DirectoryUser::class)
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-header-title">
                                {{ __('Directories') }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-nowrap card-table">
                        <thead>
                        <tr>
                            <th>
                                {{ __('Directory') }}
                            </th>
                            <th>
                                {{ __('Username') }}
                            </th>
                            <th class="text-right">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->directoryUsers as $directoryUser)
                            <tr>
                                <td>
                                    {{ $directoryUser->directory->name }}
                                </td>
                                <td>
                                    {{ $directoryUser->username }}
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fe fe-more-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('update', $directoryUser)
                                                <a href="{{ action('App\DirectoryUserController@edit', $directoryUser) }}" class="dropdown-item">
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
        @endcan
        @can('viewAny', \App\Models\ApplicationUser::class)
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-header-title">
                                {{ __('Applications') }}
                            </h4>
                        </div>
                        <div class="col-auto">
                            @can('create', \App\Models\ApplicationUser::class)
                                <a href="{{ action('App\ApplicationUserController@create', $user) }}" class="btn btn-sm btn-primary">
                                    {{ __('Add application') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-nowrap card-table">
                        <thead>
                        <tr>
                            <th>
                                <a href="#" class="text-muted">
                                    {{ __('Application') }}
                                </a>
                            </th>
                            <th>
                                <a href="#" class="text-muted">
                                    {{ __('Actions') }}
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicationUsers as $applicationUser)
                            <tr>
                                <td class="application">
                                    {{ $applicationUser->application->name }}
                                    <small class="badge badge-soft-secondary ml-1">
                                        @if($applicationUser->direct)
                                            {{  __('direct access') }}
                                        @else
                                            {{  __('via role') }}
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <button class="btn btn-white btn-sm copy-to-clipboard" data-clipboard-text="{{ $user->name }}">
                                        <span class="fe fe-copy"></span>
                                        {{ __('Copy name') }}
                                    </button>
                                    <button class="btn btn-white btn-sm copy-to-clipboard" data-clipboard-text="+{{ $user->phone_number }}">
                                        <span class="fe fe-copy"></span>
                                        {{ __('Copy phone') }}
                                    </button>
                                    @if(!is_null($applicationUser->password))
                                        <button class="btn btn-white btn-sm copy-to-clipboard" data-clipboard-text="{{ $applicationUser->password }}">
                                            <span class="fe fe-copy"></span>
                                            {{ __('Copy password') }}
                                        </button>
                                    @endif
                                    <a class="btn btn-white btn-sm" href="{{ action('App\ApplicationUserController@regeneratePasswordForm', [$user, $applicationUser->application]) }}">
                                        <span class="fe fe-refresh-cw"></span>
                                        {{ __('Re-generate password') }}
                                    </a>
                                    @can('delete', $applicationUser)
                                        <form role="form" class="d-inline" method="POST" action="{{ action('App\ApplicationUserController@destroy', $applicationUser) }}">
                                            @csrf

                                            <input type="hidden" name="_method" value="DELETE">

                                            <button class="btn btn-white btn-sm" type="submit">{{ __('Revoke access') }}</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan
        
        @can('viewAny', \App\Models\Document::class)
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">
                        {{ __('Documents') }}
                    </h4>
                </div>
                @can('create', \App\Models\Document::class)
                    <div class="card-body">
                        <div id="upload-control">
                            <form method="post" action="{{ action('App\DocumentController@store', $user) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group position-relative">
                                    <x-forms.upload-drag-and-drop :name="'document'" />
                                </div>

                                <input type="submit" class="btn btn-primary" value="{{ __('Upload') }}"/>
                            </form>
                        </div>
                    </div>
                @endcan
                <div class="user-documents">
                    <div class="table-responsive">
                        <table class="table table-sm card-table">
                            <tbody>
                            @foreach($user->documents->sortByDesc('created_at') as $document)
                                <tr class="document-row" data-folder-id="{{ $document->folder_id }}" title="{{ $document->name }}">
                                    <td>
                                        <a href="{{ action('App\DocumentController@view', $document) }}" target="_blank">
                                            <span class="fe fe-document" aria-hidden="true" ></span> {{ \Illuminate\Support\Str::limit($document->title, 45, '...') }}
                                        </a>
                                    </td>
                                    <td class="text-right text-nowrap">{{ $document->created_at }}</td>
                                    <td class="text-right text-nowrap">{{ __('By') }} <a href="{{ action('App\UserController@show', $user) }}">{{ $document->uploader->name }}</a></td>

                                    <td class="text-right text-nowrap">
                                        <a class="text-info mr-2" target="_blank" href="{{ action('App\DocumentController@view', $document) }}">
                                            <span class="fe fe-eye mr-2" aria-hidden="true"></span>
                                        </a>
                                        <a class="text-info mr-2" target="_blank" href="{{ action('App\DocumentController@download', $document) }}">
                                            <span class="fe fe-download-cloud mr-2" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>
@endsection

@section('script')
    <script>
        new ClipboardJS('.copy-to-clipboard');

        $('.copy-popover').on('shown.bs.popover', function () {
            let popover = $(this);
            setTimeout(function () {
                popover.popover('hide');
            }, 1000);
        });

        $('.dragupload input').change(function () {
            $(this).siblings('span').text(this.files[0].name + " {{ __(' selected') }}");
        });
    </script>
@append
