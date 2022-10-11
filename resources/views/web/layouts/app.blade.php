<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ env('COMPANY_NAME' ) }}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- CSS Libraries --}}
    <link rel="stylesheet" href="{{ asset('/web/fonts/Feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('/web/libs/@fancyapps/fancybox/dist/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/web/libs/aos/dist/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('/web/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/web/libs/flickity-fade/flickity-fade.css') }}">
    <link rel="stylesheet" href="{{ asset('/web/libs/flickity/dist/flickity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/web/libs/highlightjs/styles/vs2015.css') }}">
    <link rel="stylesheet" href="{{ asset('/web/libs/jarallax/dist/jarallax.css') }}">
    <link rel="stylesheet" href="{{ asset('/web/libs/quill/dist/quill.core.css') }}">

    {{-- Theme CSS --}}
    <link rel="stylesheet" href="{{ asset('/web/css/theme.min.css') }}">

    {{-- Web CSS --}}
    <link rel="stylesheet" href="{{ asset('css/web.css') }}">

    @livewireStyles

    @yield('head')

    <title>@yield('title', env('COMPANY_NAME'))</title>
</head>
<body>
    {{-- Navigation --}}
    @include('web.layouts.navigation')

    {{-- Breadcrumbs --}}
    @yield('breadcrumbs')

    {{-- Main Content --}}
    @yield('content')

    {{-- Main Footer --}}
    @include('web.layouts.footer')

    {{-- Javascript Libraries --}}
    <script src="{{ asset('web/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('web/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('web/libs/@fancyapps/fancybox/dist/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('web/libs/aos/dist/aos.js') }}"></script>
    <script src="{{ asset('web/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('web/libs/countup.js/dist/countUp.min.js') }}"></script>
    <script src="{{ asset('web/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('web/libs/flickity/dist/flickity.pkgd.min.js') }}"></script>
    <script src="{{ asset('web/libs/flickity-fade/flickity-fade.js') }}"></script>
    <script src="{{ asset('web/libs/highlightjs/highlight.pack.min.js') }}"></script>
    <script src="{{ asset('web/libs/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('web/libs/isotope-layout/dist/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('web/libs/jarallax/dist/jarallax.min.js') }}"></script>
    <script src="{{ asset('web/libs/jarallax/dist/jarallax-video.min.js') }}"></script>
    <script src="{{ asset('web/libs/jarallax/dist/jarallax-element.min.js') }}"></script>
    <script src="{{ asset('web/libs/quill/dist/quill.min.js') }}"></script>
    <script src="{{ asset('web/libs/smooth-scroll/dist/smooth-scroll.min.js') }}"></script>
    <script src="{{ asset('web/libs/typed.js/lib/typed.min.js') }}"></script>

    {{-- Shared Javascript Libraries --}}
    <script src="{{ asset('shared/libs/tinymce/tinymce.min.js') }}"></script>

    {{-- Theme Javascript --}}
    <script src="{{ asset('web/js/theme.min.js') }}"></script>

    {{-- App Javascript --}}
    <script src="{{ asset('js/web.js') }}"></script>
    <script src="{{ asset('js/shared.js') }}"></script>

    @livewireScripts

    {{-- Custom scripts --}}
    @yield('script')
    @yield('javascript')
</body>
</html>
