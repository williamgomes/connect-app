@extends('app.layouts.app')

@section('title', __('Add role'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\UserController@index') }}">{{ __('Users') }}</a> /
                        <a href="{{ action('App\UserController@show', $user) }}">{{ $user->name }}</a> /
                        <a href="{{ action('App\UserController@show', $user) }}">{{ __('Roles') }}</a> /
                        {{ __('Add') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Add Role') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\RoleUserController@store', $user) }}">
        @csrf

        <div class="form-group">
            <label>{{ __('Role') }}</label>

            <select class="form-control" data-toggle="select" name="role_id" id="role_id">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('role_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('role_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Company') }}</label>

            <select class="form-control" data-toggle="select" name="company_id" id="company_id">
                {{-- The options will be loaded via AJAX --}}
            </select>

            @if ($errors->has('company_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('company_id') }}</strong>
                </span>
            @endif
        </div>

        <hr class="mt-5 mb-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Add role') }}
        </button>

        <a href="{{ action('App\UserController@show', $user) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        let companyFormGroup = $('#company_id').closest('.form-group');
        let roleDirectoryIds = @json($roleDirectoryIds);

        $('#role_id').on('change', function () {
            let roleId = $(this).val();
            let directoryId = roleDirectoryIds[roleId];

            if (!directoryId) {
                $('#company_id').find('option').remove();
                return;
            }

            let getCompaniesEndpoint = "{{ action('Ajax\DirectoryController@companies', 'DIRECTORY_ID') }}";
            let getCompaniesUrl = getCompaniesEndpoint.replace('DIRECTORY_ID', directoryId);

            $.ajax({
                url: getCompaniesUrl,
                method: 'GET',
            }).done(function (response) {
                if (response.data.length) {
                    let companies = response.data;

                    let html = '<option selected></option>';
                    for (let i = 0; i < companies.length; i++) {
                        html += "<option value=" + companies[i].id + ">" + companies[i].name + "</option>";
                    }
                    $('#company_id').html(html).trigger('change');
                } else {
                    companyFormGroup.addClass('d-none');
                }
            });
            
            companyFormGroup.removeClass('d-none');
        }).trigger('change');
    </script>
@append

