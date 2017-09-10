<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('partials.head', ['stylesheet' => 'app.css'])
<body>
<div class="grid-x page-container">
    <div class="small-12 large-12 cell off-canvas-wrapper">
        @include('partials.header')

        <div class="content off-canvas-content" data-off-canvas-content>
            @yield('content')
        </div>

        <div class="footer">
            {!! __('system.copyright') !!}
        </div>
    </div>
</div>
@include('partials.scripts')
</body>
</html>
