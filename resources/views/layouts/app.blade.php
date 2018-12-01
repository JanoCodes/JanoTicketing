<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('partials.head', ['stylesheet' => 'app.css'])
<body>
<div class="container-fluid page-container" id="container">
    @include('partials.header')

    <main class="container content">
        @yield('content')
    </main>

    <div class="footer">
        <div class="container">
            {!! __('system.copyright') !!}
        </div>
    </div>
</div>
<div class="slideout-menu d-md-none" id="responsive-menu">
    <a href="{{ url('/') }}">
        <img class="logo" src="{{ asset('images/logo.png') }}" />
    </a>
    <button class="close sidebar-close" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    {!! Menu::frontend()->addClass('nav flex-column') !!}
</div>
@include('partials.scripts', ['script' => 'app.js'])
</body>
</html>
