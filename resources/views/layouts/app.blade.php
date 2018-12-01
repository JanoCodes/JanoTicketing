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
<script type="text/javascript">
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

    if (width < 768) {
        var slideout = new Slideout({
            'panel': document.getElementById('container'),
            'menu': document.getElementById('responsive-menu'),
            'padding': 256,
            'tolerance': 70
        });

        $('.sidebar-toggle').on('click', function() {
            slideout.toggle();
        });
        $('.sidebar-close').on('click', function() {
            slideout.close();
        });
    }
</script>
</body>
</html>
