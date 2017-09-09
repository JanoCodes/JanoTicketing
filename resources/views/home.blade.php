@extends('layouts.app')

@section('title', __('system.home'))

@section('content')
    <div class="grid-x">
        <div class="small-12 medium-7 large-8 cell">
            <div class="card event-card">
                <div class="event-cover" style="background-image:
                    url({{ asset('images/' . Setting::get('event.cover_image')) }});" />&nbsp;</div>
                <div class="event-info">
                    <span>
                        <h2>{{ Setting::get('event.name') }}</h2>
                    </span>
                </div>
                <div class="card-section text-center event-details">
                    {{ Setting::get('event.date') }}<br />
                    Location: Secret
                    <div class="event-map" id="map">
                        <iframe width="100%" height="100%" frameborder="0" style="border:0"
                            src="https://www.google.com/maps/embed/v1/view?key=
                            {{ Setting::get('system.google_maps_key') }}&center=52.2005954,0.1214614
                            &zoom=12">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-12 medium-5 large-4 cell">
            <div class="callout event-side">
                <h3>{{ __('system.order_tickets') }}</h3>
                <a class="button success" href="{{ url('/event') }}">{{ __('system.order') }}</a>
            </div>
        </div>
    </div>
@endsection