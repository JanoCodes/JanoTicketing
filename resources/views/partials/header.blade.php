<div class="top-bar">
    <div class="top-bar-left header-left">
        <button class="clear button secondary show-for-small-only sidebar-toggle" type="button" data-toggle="responsive-menu">
            <i class="fa fa-bars fa-2x"></i>
        </button>
        <a href="{{ url('/') }}">
            <img class="logo" src="{{ asset('images/logo.png') }}" />
        </a>
    </div>
    <div class="top-bar-right hide-for-small-only">
        {!! Menu::frontend()->addClass('menu horizontal') !!}
    </div>
</div>
<div class="off-canvas position-left sidebar" id="responsive-menu" data-off-canvas>
    <a href="{{ url('/') }}">
        <img class="logo" src="{{ asset('images/logo.png') }}" />
    </a>
    <button class="close-button" aria-label="Close Menu" type="button" data-close>
        <span aria-hidden="true">&times;</span>
    </button>
    {!! Menu::frontend()->addClass('menu vertical') !!}
</div>