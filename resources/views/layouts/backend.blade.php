<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('partials.head', ['stylesheet' => 'backend.css'])
<body>
<div class="grid-x page-container">
    <div class="small-12 large-12 cell off-canvas-wrapper">
        <div class="content grid-x">
            <div class="shrink cell off-canvas in-canvas-for-medium sidebar" id="sidebar"
                data-off-canvas data-transition="overlap">
                <a class="logo" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" />
                </a>
                <button class="close-button show-for-small-only" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
                {!! Menu::backend()->addClass('menu vertical') !!}
            </div>
            <div class="auto cell main-content off-canvas-content" data-off-canvas-content>
                <div class="mobile-header show-for-small-only">
                    <button class="button clear" data-toggle="sidebar">
                        <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                    </button>
                    <img src="{{ asset('images/logo.png') }}" />
                </div>
                <div class="header grid-x">
                    <div class="auto cell">
                        <h3>@yield('title')</h3>
                    </div>
                    <div class="menu-container shrink cell">
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
                @yield('content')
                <div class="footer">
                    {!! __('system.copyright') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.scripts')
</body>
</html>
