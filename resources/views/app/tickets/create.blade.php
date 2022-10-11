@extends('app.layouts.app')

@section('title', __('Create ticket'))

@section('breadcrumbs')
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="header-pretitle">
                        {{ __('Overview') }} /
                        <a href="{{ action('App\TicketController@index') }}">{{ __('Tickets') }}</a> /
                        {{ __('Create') }}
                    </h6>
                    <h1 class="header-title">
                        {{ __('Create ticket') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form class="mb-4" method="POST" action="{{ action('App\TicketController@store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="form-group">
            <label>{{ __('Title') }}</label>
            <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                   name="title" value="{{ old('title') }}" placeholder="{{ __('Enter title') }}" required autofocus>

            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        {{-- Requested by --}}
        <div class="form-group">
            <label for="requester_id">{{ __('Requested by') }}</label>
            <select class="form-control {{ $errors->has('requester_id') ? ' is-invalid' : '' }}" name="requester_id" id="requester_id" data-toggle="select" data-options='{"theme": "max-results-5", "placeholder": "{{ __('Select a requester') }}"}'>
                <option></option>
                @foreach($requesters as $requester)
                    <option value="{{ $requester->id }}" {{ (old('requester_id') == $requester->id) ? ' selected' : '' }}>{{ $requester->name . ' (' . $requester->synega_id . ')' }}</option>
                @endforeach
            </select>

            @if ($errors->has('requester_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('requester_id') }}</strong>
                </span>
            @endif
        </div>

        {{-- Category --}}
        <div class="form-group">
            <label>{{ __('Category') }}</label>

            <select class="form-control" data-toggle="select" data-options='{"theme": "max-results-5"}' name="category_id" id="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('category_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
            @endif
        </div>

        {{-- Subcategory --}}
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
                    <option value="{{ $service->id }}">
                        {{ $service->name }}
                        ({{ $service->identifier }})
                    </option>
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
                    <option value="{{ $country->id }}">
                        {{ $country->name }}
                        ({{ $country->identifier }})
                    </option>
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
                    <option value="{{ $priority->id }}" {{ (old('priority_id') == $priority->id) ? ' selected' : '' }}>{{ $priority->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('priority_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('priority_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>{{ __('Issues') }}</label>
            <select class="form-control" data-toggle="select" name="issues[]" id="issues" multiple>
                @foreach($issues as $issue)
                    <option value="{{ $issue->id }}" {{ collect(old('issues'))->contains($issue->id) ? 'selected' : '' }}>{{ $issue->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('issues'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('issues') }}</strong>
                </span>
            @endif
        </div>

        <div id="categoryFieldsBlock"></div>

        {{-- Comment --}}
        <div id="commentBlock" class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
            <label for="comment">{{ __('Public Comment') }}</label>

            <textarea class="wysiwyg" name="comment">{!! old('comment') !!}</textarea>
            @if ($errors->has('comment'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('comment') }}</strong>
                </span>
            @endif
        </div>

        {{-- Attachments --}}
        <div class="form-group{{ $errors->has('attachments') ? ' has-error' : '' }}">
            <label for="attachments">{{ __('Attachments') }}</label>
            <div class="col-md-12 px-0 mt-3">
                <div class="dragupload d-flex align-items-center justify-content-center">
                    <input type="file" id="attachments" name="attachments[]" multiple/>
                    <span class="text-muted">{{ __('Drag your file(s) or click here to upload') }}</span>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <button type="submit" class="btn btn-block btn-primary">
            {{ __('Create ticket') }}
        </button>

        <a href="{{ action('App\TicketController@index') }}" class="btn btn-block btn-link text-muted">
            {{ __('Cancel creation') }}
        </a>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $('.dragupload input').change(function () {
            $(this).siblings('span').text(this.files.length + " files selected");
        });

        let subcategoryFormGroup = $('#subcategory_id').closest('.form-group');

        $('#category_id').on('change', function () {
            let categoryId = $(this).val();
            let getSubcategoriesEndpoint = "{{ action('Ajax\CategoryController@subcategories', 'CATEGORY_ID') }}";
            let getSubcategoriesUrl = getSubcategoriesEndpoint.replace('CATEGORY_ID', categoryId);
            let getFieldsEndpoint = "{{ action('Ajax\CategoryController@fields', 'CATEGORY_ID') }}";
            let getFieldsUrl = getFieldsEndpoint.replace('CATEGORY_ID', categoryId);
            let categoryFieldsBlock = $('#categoryFieldsBlock');
            let commentBlock = $('#commentBlock');

            $.ajax({
                url: getSubcategoriesUrl,
                method: 'GET',
            }).done(function (response) {
                if (response.data.length) {
                    let subcategories = response.data;

                    let html = '<option selected></option>';
                    for (let i = 0; i < subcategories.length; i++) {
                        html += "<option value=" + subcategories[i].id + ">" + subcategories[i].name + "</option>";
                    }
                    $('#subcategory_id').html(html).trigger('change');
                } else {
                    subcategoryFormGroup.addClass('d-none');
                }
            });
            subcategoryFormGroup.removeClass('d-none');

            $.ajax({
                url: getFieldsUrl,
                method: 'GET',
            }).done(function (response) {
                if (response) {
                    let html = response.html;

                    if (html) {
                        categoryFieldsBlock.html(html);
                        commentBlock.addClass('d-none');
                    } else {
                        commentBlock.removeClass('d-none');
                        categoryFieldsBlock.empty();
                    }
                }
            });

        }).trigger('change');
    </script>
@append
