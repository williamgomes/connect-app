<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ env('COMPANY_NAME' ) }}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- CSS Libraries --}}
    <link rel="stylesheet" href="{{ asset('app/fonts/feather/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('app/libs/flatpickr/dist/flatpickr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('app/libs/quill/dist/quill.core.css') }}" />
    <link rel="stylesheet" href="{{ asset('app/libs/highlightjs/styles/vs2015.css') }}" />
    <link rel="stylesheet" href="{{ asset('app/libs/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('app/libs/jquery-ui/jquery-ui.min.css') }}">

    {{-- Theme CSS --}}
    <link rel="stylesheet" href="{{ asset('app/css/theme.min.css') }}">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('head')

    <title>@yield('title', env('COMPANY_NAME'))</title>
</head>
<body>
    {{-- Sidebar --}}
    @include('app.layouts.navigation')

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Heading --}}
        @yield('heading')

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    {{-- Breadcrumbs --}}
                    @yield('breadcrumbs')

                    {{-- Flash Alerts --}}
                    @include('app.layouts.flash-alerts')

                    {{-- Content --}}
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    {{-- Javascript Libraries --}}
    <script src="{{ asset('app/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('app/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('app/libs/@shopify/draggable/lib/es5/draggable.bundle.legacy.js') }}"></script>
    <script src="{{ asset('app/libs/autosize/dist/autosize.min.js') }}"></script>
    <script src="{{ asset('app/libs/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('app/libs/clipboard.js/clipboard.min.js') }}"></script>
    <script src="{{ asset('app/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('app/libs/flatpickr/dist/flatpickr.min.js') }}"></script>
    <script src="{{ asset('app/libs/highlightjs/highlight.pack.min.js') }}"></script>
    <script src="{{ asset('app/libs/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('app/libs/jquery-ui/jquery.multisortable.js') }}"></script>
    <script src="{{ asset('app/libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('app/libs/list.js/dist/list.min.js') }}"></script>
    <script src="{{ asset('app/libs/quill/dist/quill.min.js') }}"></script>
    <script src="{{ asset('app/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('app/libs/chart.js/Chart.extension.js') }}"></script>
    <script src="{{ asset('app/libs/sweetalert/sweetalert.min.js') }}"></script>

    {{-- Shared Javascript Libraries --}}
    <script src="{{ asset('shared/libs/tinymce/tinymce.min.js') }}"></script>

    {{-- Theme Javascript --}}
    <script src="{{ asset('app/js/theme.min.js') }}"></script>
    <script src="{{ asset('app/js/dashkit.min.js') }}"></script>

    {{-- App Javascript --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/shared.js') }}"></script>

    {{-- Custom scripts --}}
    @yield('script')
    @yield('javascript')
</body>
</html>
