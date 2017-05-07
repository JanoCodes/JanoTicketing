<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ Setting::get('system.title') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div class="expanded row off-canvas-wrapper">
    <div class="small-12 large-3 columns sidebar-wrapper">
        @include('partials.sidebar')
    </div>
    <div class="small-12 large-9 columns off-canvas-content" data-off-canvas-content>
        <div class="row mobile-header hide-for-large">
            <div class="small-2 columns">
                <button class="header-icon" type="button" data-open="sidebarCanvas"><i class="fa fa-bars fa-3x"></i></button>
            </div>
            <div class="small-8 columns">
                <img class="logo" src="{{ asset('images/logo.png') }}" />
            </div>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>
    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
