<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ __('system.jano_ticketing_system') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div class="grid-x page-container">
    <div class="small-12 large-12 cell off-canvas-wrapper">
        <div class="top-bar">
            <div class="top-bar-left header-left">
                <button class="clear button secondary show-for-small-only sidebar-toggle" type="button"
                    data-toggle="responsive-menu">
                    <i class="fa fa-bars fa-2x"></i>
                </button>
                <a href="{{ url('/') }}">
                    <img class="logo" src="{{ asset('images/logo.png') }}" />
                </a>
            </div>
            <div class="top-bar-right">
                <ul class="menu horizontal">
                    <li>
                        <a class="clear button" href="#">
                            {{ Auth::user()->first_name }}
                            <span class="hide-for-small-only">{{ Auth::user()->last_name }}</span>
                        </a>
                    </li>
                    <li>
                        <form method="post" action="{{ url('logout') }}">
                            {{ csrf_field() }}
                            <button class="button clear" type="submit" aria-label="{{ __('system.logout') }}">
                                <i class="fa fa-2x fa-sign-out" aria-hidden="true"></i>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content grid-x off-canvas-content" data-off-canvas-content>
            <div class="medium-3 large-2 cell sidebar">
                {!! Menu::backend()->addClass('menu vertical') !!}
            </div>
            <div class="medium-9 large-10 cell">
                @yield('content')
                <div class="footer">
                    {!! __('system.copyright') !!}
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
