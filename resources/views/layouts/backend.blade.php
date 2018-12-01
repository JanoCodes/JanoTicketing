<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('partials.head', ['stylesheet' => 'backend.css'])
<body>
<div class="container-fluid m-0 p-0 page-container" id="container">
    <div class="col-sm-12 col-lg-12 p-0">
        <div class="content d-flex">
            <div class="d-none d-md-block flex-md-shrink-1 sidebar">
                <a class="logo" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" />
                </a>
                {!! Menu::backend()->addClass('nav flex-column') !!}
            </div>
            <div class="flex-md-grow-1 main-content">
                <div class="mobile-header d-block d-md-none">
                    <button class="btn btn-link sidebar-toggle">
                        <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                    </button>
                    <img src="{{ asset('images/logo.png') }}" />
                </div>
                <div class="header d-flex">
                    <div class="flex-grow-1 d-flex align-items-center">
                        <h3>@yield('title')</h3>
                    </div>
                    <div class="flex-shrink-0 menu-container">
                        <ul class="nav">
                            <li class="nav-item d-flex align-items-center">
                                <a class="nav-link" href="#">
                                    {{ Auth::user()->first_name }}
                                    <span class="d-none d-md-inline-block">{{ Auth::user()->last_name }}</span>
                                </a>
                            </li>
                            <li class="nav-link">
                                <form method="post" action="{{ url('logout') }}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-link" type="submit" aria-label="{{
                                        __('system.logout') }}">
                                        <i class="fas fa-2x fa-sign-out-alt" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="container-fluid">
                    @yield('content')
                </div>
                <div class="footer">
                    {!! __('system.copyright') !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="slideout-menu sidebar d-md-none" id="responsive-menu">
    <a class="logo" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" />
    </a>
    <span class="text-right">
        <button class="close sidebar-close">
            <span aria-hidden="true">&times;</span>
        </button>
    </span>
    {!! Menu::backend()->addClass('nav flex-column') !!}
</div>
@include('partials.scripts', ['script' => 'backend.js'])
</body>
</html>
