<div class="navbar navbar-expand-md header">
    <div class="container">
        <button class="clear button secondary d-block d-md-none sidebar-toggle" type="button"
                data-toggle="collapse" data-target="#responsive-menu">
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
    </div>
</div>
<div class="collapse position-absolute sidebar" id="responsive-menu">
    <a href="{{ url('/') }}">
        <img class="logo" src="{{ asset('images/logo.png') }}" />
    </a>
    <button class="close-button" type="button" data-close>
        <span aria-hidden="true">&times;</span>
    </button>
    {!! Menu::frontend()->addClass('nav flex-column') !!}
</div>