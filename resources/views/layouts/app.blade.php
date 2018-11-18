<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('partials.head', ['stylesheet' => 'app.css'])
<body>
<div class="container-fluid page-container">
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
@include('partials.scripts', ['script' => 'app.js'])
</body>
</html>
