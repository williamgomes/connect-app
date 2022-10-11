@extends('app.layouts.app')

@section('title', __('Edit ticket'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\TicketController@index') }}">{{ __('Tickets') }}</a> /
                        <a href="{{ action('App\TicketController@show', $ticket) }}">{{ $ticket->title }}</a> /
                        {{ __('Edit') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Edit ticket') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\TicketController@update', $ticket) }}" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="form-group">
            <label>{{ __('Title') }}</label>
            <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                   name="title" value="{{ old('title', $ticket->title) }}" placeholder="{{ __('Enter title') }}" required autofocus>

            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        {{-- Assigned to --}}
        <div class="form-group">
            <label for="user_id">{{ __('Assigned to') }}</label>
            <select class="form-control {{ $errors->has('user_id') ? ' is-invalid' : '' }}" name="user_id" id="user_id" data-toggle="select" data-options='{"theme": "max-results-5"}'>
                <option value="">{{ __('Unassigned') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (old('user_id', $ticket->user_id) == $user->id) ? ' selected' : '' }}>{{ $user->name . ' (' . __(\App\Models\User::$roles[$user->role]) . ')' }}</option>
                @endforeach
            </select>

            @if ($errors->has('user_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
            @endif
        </div>

        {{-- Requested by --}}
        <div class="form-group">
            <label for="requester_id">{{ __('Requested by') }}</label>
            <select class="form-control {{ $errors->has('requester_id') ? ' is-invalid' : '' }}" name="requester_id" id="requester_id" data-toggle="select" data-options='{"theme": "max-results-5"}'>
                @foreach($requesters as $requester)
                    <option value="{{ $requester->id }}" {{ (old('requester_id', $ticket->requester_id) == $requester->id) ? ' selected' : '' }}>{{ $requester->name . ' (' . $requester->synega_id . ')' }}</option>
                @endforeach
            </select>

            @if ($errors->has('requester_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('requester_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Category') }}</label>

            <select class="form-control" data-toggle="select" name="category_id" id="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (old('category_id', $ticket->category->parentCategory->id ?? $ticket->category->id) == $category->id) ? ' selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('category_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group d-none">
            <label>{{ __('Subcategory') }} <small class="text-muted ml-2">{{ __('Optional') }}</small></label>

            <select class="form-control" data-toggle="select" data-options='{"theme": "max-results-5", "allowClear": true, "placeholder": "{{ __('No subcategory') }}"}' name="subcategory_id" id="subcategory_id">
                {{-- Will be filled via AJAX --}}
            </select>

            @if ($errors->has('subcategory_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('subcategory_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Service') }}</label>

            <select class="form-control" data-toggle="select" name="service_id" id="service_id">
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ (old('service_id', $ticket->service_id) == $service->id) ? ' selected' : '' }}>{{ $service->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('service_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('service_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Country') }}</label>

            <select class="form-control" data-toggle="select" name="country_id" id="country_id">
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ (old('country_id', $ticket->country_id) == $country->id) ? ' selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('country_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('country_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Priority') }}</label>

            <select class="form-control" data-toggle="select" name="priority_id" id="priority_id">
                @foreach($priorities as $priority)
                    <option value="{{ $priority->id }}" {{ (old('priority_id', $ticket->priority_id) == $priority->id) ? ' selected' : '' }}>{{ $priority->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('priority_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('priority_id') }}</strong>
                </span>
            @endif
        </div>
        
        {{-- Hidden issues attribute in payload so that user can clear all relations in pivot table --}}
        <input type="hidden" name="issues" value="">
        <div class="form-group">
            <label>{{ __('Issues') }}</label>
            <select class="form-control" data-toggle="select" name="issues[]" id="issues" multiple>
                @foreach($issues as $issue)
                    <option value="{{ $issue->id }}" {{ collect(old('issues', $ticket->issues->pluck('id')))->contains($issue->id) ? 'selected' : '' }}>{{ $issue->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('issues'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('issues') }}</strong>
                </span>
            @endif
        </div>

        <hr class="my-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Update ticket') }}
        </button>

        <a href="{{ action('App\TicketController@show', $ticket) }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel update') }}
        </a>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        let subcategoryFormGroup = $('#subcategory_id').closest('.form-group');

        $('#category_id').on('change', function () {
            let categoryId = $(this).val();
            let getSubcategoriesEndpoint = "{{ action('Ajax\CategoryController@subcategories', 'CATEGORY_ID') }}";
            let getSubcategoriesUrl = getSubcategoriesEndpoint.replace('CATEGORY_ID', categoryId);

            $.ajax({
                url: getSubcategoriesUrl,
                method: 'GET',
            }).done(function (response) {
                if (response.data.length) {
                    let subcategories = response.data;

                    let html = '<option selected></option>';
                    for (let i = 0; i < subcategories.length; i++) {
                        let selected = subcategories[i].id == '{{ old('subcategory_id', $ticket->category->id) }}' ? ' selected' : '';
                        html += "<option value=" + subcategories[i].id + selected + ">" + subcategories[i].name + "</option>";
                    }
                    $('#subcategory_id').html(html).trigger('change');
                } else {
                    subcategoryFormGroup.addClass('d-none');
                }
            });
            subcategoryFormGroup.removeClass('d-none');

        }).trigger('change');

        $('form').one("submit", function (e) {
            e.preventDefault();

            $('.d-none').remove();

            $(this).submit();
        });
    </script>
@append
