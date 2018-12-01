<div class="navbar navbar-expand-md header">
    <div class="container">
        <button class="btn btn-link d-block d-md-none sidebar-toggle" type="button">
            <i class="fa fa-bars fa-2x"></i>
        </button>
        <div class="navbar-brand">
            <a href="{{ url('/') }}">
                <img class="logo" src="{{ asset('images/logo.png') }}" />
            </a>
        </div>
        <div class="d-none d-md-flex flex-grow-1">
            {!! Menu::frontend()->addClass('navbar-nav ml-auto') !!}
        </div>
        <div class="d-xs-block">&nbsp;</div>
    </div>
</div>