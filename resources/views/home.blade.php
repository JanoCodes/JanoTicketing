@extends('layouts.app')

@section('title', __('system.home'))

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-7 col-lg-8">
            <div class="card event-card">
                <div class="event-cover" style="background-image:
                    url({{ asset('images/' . Setting::get('event.cover_image')) }});">&nbsp;</div>
                <div class="event-info">
                    <h2 class="event-name">{{ Setting::get('event.name') }}</h2>
                </div>
                <div class="card-body text-center event-details">
                    <h5>{{ $event_date['from']->format('j M, Y g:i a') }} {{ __('system.to') }} {{ $event_date['to']->format('j M, Y g:i a') }}</h5>
                    {{ Setting::get('event.location.name') }}
                    <div class="event-map" id="map">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 col-lg-4">
            <div class="card event-side">
                <div class="card-body">
                    @if (Auth::check())
                        <h3>{{ __('system.order_tickets') }}</h3>
                        <a class="btn btn-primary" href="{{ url('/event') }}">{{ __('system.order') }}</a>
                    @else
                        <h4>{!! __('system.login_required') !!}</h4>
                        @include('auth.modal')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    mapboxgl.accessToken = '{{ Setting::get('mapbox.access_token') }}';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v10',
        center: [{{ Setting::get('event.location.long') }}, {{ Setting::get('event.location.lat') }}],
        zoom: 14,
        minZoom: 13,
        attributionControl: false
    })
        .addControl(new mapboxgl.AttributionControl({
            compact: false
        }));
</script>
@endpush