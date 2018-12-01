<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('partials.head', ['stylesheet' => 'app.css'])
<body>
<div class="grid-x page-container">
    <div class="small-12 large-12 cell">
        @yield('content')
    </div>
</div>
</body>
</html>