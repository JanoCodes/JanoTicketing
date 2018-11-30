@extends('layouts.backend')

@section('title', __('system.settings'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form role="form" method="POST" action="{{ route('backend.settings.update') }}" data-abide novalidate>
    @include('partials.error')
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label">
            <strong>{{ __('system.event_name') }}</strong>
        </label>
        <div class="col-sm-9 col-lg-8">
            <input type="text" name="event.name" id="event_name" class="form-control" pattern="text"
                   value="{{ Setting::get('event.name') }}" required>
        </div>
    </div>
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label">
            <strong>{{ __('system.event_date') }}</strong>
        </label>
        <div class="col-sm-9 col-lg-8">
            <div class="input-group date-range-selector">
                <input type="text" name="event.date.from" id="event_date" pattern="text"
                       class="form-control" value="{{ Setting::get('event.date.from') }}" required>
                <div class="input-group-append">
                    <span class="input-group-text">{{ __('system.to') }}</span>
                </div>
                <input type="text" name="event.date.to" id="event_date" pattern="text"
                       class="form-control" value="{{ Setting::get('event.date.to') }}" required>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label">
            <strong>{{ __('system.event_location') }}</strong>
        </label>
        <div class="col-sm-9 col-lg-8">
            <button type="button" data-toggle="modal" data-target="#location-select" class="btn btn-outline-primary">
                {{ __('system.select_location') }}
            </button>
            <div class="modal" id="location-select" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ __('system.select_location') }}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <label class="col-sm-12 col-md-4 col-form-label">
                                    {{ __('system.location_name') }}
                                </label>
                                <div class="col-sm-12 col-md-8" id="geocoder">
                                </div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <span><strong>{{ __('system.drag_marker_to_location') }}</strong></span>
                                    <div class="location-map-container">
                                        <div id="map" class="location-map"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="offset-sm-3 col-sm-9 offset-lg-3 col-lg-8">
            <strong>{{ __('system.payment_information') }}</strong>
        </div>
    </div>
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label">
            {{ __('system.currency') }}
        </label>
        <div class="col-sm-9 col-lg-8">
            <input type="text" name="payment.currency" id="payment_currency" class="form-control" pattern="text"
                value="{{ Setting::get('payment.currency') }}" required>
        </div>
    </div>
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label">
            {{ __('system.time_for_payment') }}
        </label>
        <div class="col-sm-9 col-lg-8">
            <div class="input-group">
                <input type="number" name="payment.deadline" id="payment_deadline" pattern="integer"
                    class="form-control" value="{{ Setting::get('payment.deadline') }}" required>
                <div class="input-group-append">
                    <span class="input-group-text">{{ __('system.days') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label">
            <strong>{{ __('system.terms') }}</strong>
        </label>
        <div class="col-sm-9 col-lg-8">
            <input type="hidden" name="agreement" value="">
            <div class="textarea" id="agreement">{!! Setting::get('agreement') !!}</div>
        </div>
    </div>
    <div class="row">
        <div class="offset-sm-3 col-sm-9 offset-lg-3 col-lg-8">
            <input class="btn btn-primary" type="submit" value="{{ __('system.update') }}" />
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.date-range-selector > input').each(function() {
            $(this).flatpickr({
                altFormat: 'j M Y h:i K',
                altInput: true,
                dateFormat: 'Y-m-d H:i',
                enableTime: true,
            });
        });

        const agreement = $('#agreement').html();

        let agreementQuill = new Quill('#agreement', {
            theme: 'snow',
            modules: {
                clipboard: {},
                history: {},
                toolbar: [
                    [{'color': []}, 'bold', 'italic'],
                    [{'script': 'sub'}, {'script': 'super'}, 'underline'],
                    [{'list': 'bullet'}, {'list': 'ordered'}, {'align': []}, 'link']
                ]
            }
        });
        agreementQuill.clipboard.dangerouslyPasteHTML(agreement);

        $('form').submit(function(event) {
            event.preventDefault();

            $('input[name=agreement]').val(agreementQuill.root.innerHTML);
            $(this).unbind('submit').submit();
        });

        mapboxgl.accessToken = '{{ Setting::get('mapbox.access_token') }}';
        let map = new mapboxgl.Map({
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

        let marker = new mapboxgl.Marker({
            draggable: true
        })
            .setLngLat([{{ Setting::get('event.location.long') }}, {{ Setting::get('event.location.lat') }}])
            .addTo(map);

        let geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken
        })
            .on('result', function (result) {
                marker.setLngLat(result.result.center);
            });
        $('#geocoder').append(geocoder.onAdd(map));

        $('#location-select').on('shown.bs.modal', function (e) {
            map.resize();
        })
    });
</script>
@endpush