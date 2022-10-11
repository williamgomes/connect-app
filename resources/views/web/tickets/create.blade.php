@extends('web.layouts.app')

@section('title', __('Create Ticket'))

@section('breadcrumbs')
    <nav class="bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb breadcrumb-scroll">
                        <li class="breadcrumb-item">
                            <a href="{{ action('Web\TicketController@index') }}">
                                {{ __('Tickets') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ __('Create') }}
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
                        {{ __('Create a ticket') }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        {{ __("We usually respond within 24 hours during workdays.")}}
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
                            <form method="POST" action="{{ action('Web\TicketController@store') }}" enctype="multipart/form-data">
                                <div class="row">
                                    @csrf

                                    {{-- Title --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>
                                                {{ __('Title') }}
                                                <small class="text-muted">({{ __('Required') }})</small>
                                            </label>
                                            <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                                   name="title" value="{{ old('title') }}" placeholder="{{ __('Enter title') }}" required autofocus>

                                            @if ($errors->has('title'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>
                                                {{ __('Category') }}
                                                <small class="text-muted">({{ __('Required') }})</small>
                                            </label>

                                            <select class="form-control" name="category_id" id="category_id">
                                                <option disabled selected>{{ __('Select category')}}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('category_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('category_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Subcategory --}}
                                    <div class="col-12">
                                        <div class="form-group d-none">
                                            <label>{{ __('Subcategory') }} <small class="text-muted ml-2">({{ __('Optional') }})</small></label>
                                            <select class="form-control" name="subcategory_id" id="subcategory_id">
                                                {{-- Will be filled via AJAX --}}
                                            </select>

                                            @if ($errors->has('subcategory_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('subcategory_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>
                                                {{ __('Service') }}
                                                <small class="text-muted">({{ __('Required') }})</small>
                                            </label>

                                            <select class="form-control" name="service_id" id="service_id">
                                                <option disabled selected>{{ __('Select service')}}</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
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
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>
                                                {{ __('Country') }}
                                                <small class="text-muted">({{ __('Required') }})</small>
                                            </label>

                                            <select class="form-control" name="country_id" id="country_id">
                                                <option disabled selected>{{ __('Select country')}}</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
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
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>
                                                {{ __('Priority') }}
                                                <small class="text-muted">({{ __('Required') }})</small>
                                            </label>

                                            <select class="form-control" name="priority_id" id="priority_id">
                                                <option disabled selected>{{ __('Select priority')}}</option>
                                                @foreach($priorities as $priority)
                                                    <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                                        {{ $priority->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('priority_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('priority_id') }}</strong>
                                                </span>
                                            @endif

                                            <div id="description" class="alert alert-info mt-4 d-none"></div>
                                        </div>
                                    </div>

                                    <div class="col-12" id="categoryFieldsBlock"></div>

                                    <div class="col-12" id="commentBlock">
                                        {{-- Comment --}}
                                        <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                            <label for="comment">
                                                {{ __('Comment') }}
                                                <small class="text-muted">({{ __('Required') }})</small>
                                            </label>

                                            <textarea class="content-editor" name="comment">{!! old('comment') !!}</textarea>

                                            @if ($errors->has('comment'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('comment') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Attachments --}}
                                    <div class="col-12">
                                        <div class="form-group{{ $errors->has('attachments') ? ' has-error' : '' }}">
                                            <label for="attachments">
                                                {{ __('Attachments') }}
                                                <small class="text-muted">({{ __('Optional') }})</small>
                                            </label>

                                            <div class="col-md-12 px-0 mt-3">
                                                <div class="dragupload d-flex align-items-center justify-content-center">
                                                    <input type="file" id="attachments" name="attachments[]" multiple/>
                                                    <span class="text-muted">{{ __('Drag your file(s) or click here to upload') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4 col-md-auto">
                                        <button class="btn btn-block btn-primary" type="submit">
                                            {{ __('Create ticket') }}
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
    @include('app.layouts.editor-script', ['path' => 'tickets'])

    <script type="text/javascript">
        let priorityDescriptions = @json($priorityDescriptions);
        let description = $('#description');

        $('.dragupload input').change(function () {
            $(this).siblings('span').text(this.files.length + " files selected");
        });

        let subcategoryFormGroup = $('#subcategory_id').closest('.form-group');

        $('#category_id').on('change', function () {
            let categoryId = $(this).val();
            let getSubcategoriesEndpoint = "{{ action('Web\CategoryController@subcategories', 'CATEGORY_ID') }}";
            let getSubcategoriesUrl = getSubcategoriesEndpoint.replace('CATEGORY_ID', categoryId);
            let getFieldsEndpoint = "{{ action('Web\CategoryController@fields', 'CATEGORY_ID') }}";
            let getFieldsUrl = getFieldsEndpoint.replace('CATEGORY_ID', categoryId);
            let categoryFieldsBlock = $('#categoryFieldsBlock');
            let commentBlock = $('#commentBlock');

            if(! categoryId) {
                return;
            }

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
                    subcategoryFormGroup.removeClass('d-none');
                } else {
                    subcategoryFormGroup.addClass('d-none');
                }
            });

            $.ajax({
                url: getFieldsUrl,
                data: {
                    old: JSON.parse('@json(session()->getOldInput())'),
                },
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

        $('#priority_id').change(function () {
            showDescription($(this).val());
        });

        function showDescription(priorityId) {
            if (priorityDescriptions[priorityId]) {
                description.text(priorityDescriptions[priorityId])
                description.removeClass('d-none');
            } else {
                description.addClass('d-none');
            }
        }
    </script>
@append
