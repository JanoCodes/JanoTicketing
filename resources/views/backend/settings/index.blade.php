@extends('layouts.backend')

@section('title', __('system.settings'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form role="form" method="POST" action="{{ route('backend.settings.update') }}" data-abide novalidate>
    <div class="grid-x grid-padding-x">
        @include('partials.error')
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle"><strong>{{ __('system.event_name') }}</strong></label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="text" name="event.name" id="event_name" pattern="text"
                   value="{{ Setting::get('event.name') }}" required>
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle"><strong>{{ __('system.event_date') }}</strong></label>
        </div>
        <div class="small-9 large-8 cell">
            <div class="input-group date-range-selector">
                <input type="text" name="event.date.from" id="event_date" pattern="text"
                    class="input-group-field" value="{{ Setting::get('event.date.from') }}" required>
                <span class="input-group-label">{{ __('system.to') }}</span>
                <input type="text" name="event.date.to" id="event_date" pattern="text"
                    class="input-group-field" value="{{ Setting::get('event.date.to') }}" required>
            </div>
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle"><strong>{{ __('system.event_location') }}</strong></label>
        </div>
        <div class="small-9 large-8 cell">
            <button type="button" data-open="location-select" class="button hollow">
                {{ __('system.select_location') }}
            </button>
            <div class="reveal" id="location-select" data-reveal>
                <h3>{{ __('system.select_location') }}</h3>
                <div class="grid-x grid-padding-x">
                    <div class="small-12 medium-4 cell">
                        <label class="text-right middle">{{ __('system.location_name') }}</label>
                    </div>
                    <div class="small-12 medium-8 cell">
                        <input type="text" name="event.location.name" id="event_location_name"
                               pattern="text" value="{{ Setting::get('event.location.name') }}"
                               required>
                        <input type="hidden" name="event.location.lat" id="event_location_lat"
                            value="{{ Setting::get('event.location.lat') }}" required>
                        <input type="hidden" name="event.location.long" id="event_location_long"
                               value="{{ Setting::get('event.location.long') }}" required>
                    </div>
                    <div class="small-12 medium-12 cell">
                        <span><strong>{{ __('system.drag_marker_to_location') }}</strong></span>
                        <div id="map" class="location-map"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-offset-3 small-9 large-offset-3 large-8 cell">
            <strong>{{ __('system.payment_information') }}</strong>
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle">{{ __('system.currency') }}</label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="text" name="payment.currency" id="payment_currency" pattern="text"
                value="{{ Setting::get('payment.currency') }}" required>
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle">{{ __('system.time_for_payment') }}</label>
        </div>
        <div class="small-9 large-8 cell">
            <div class="input-group">
                <input type="number" name="payment.deadline" id="payment_deadline" pattern="integer"
                    class="input-group-field" value="{{ Setting::get('payment.deadline') }}" required>
                <span class="input-group-label">{{ __('system.days') }}</span>
            </div>
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle"><strong>{{ __('system.terms') }}</strong></label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="hidden" name="agreement" value="">
            <div class="textarea" id="agreement">{!! Setting::get('agreement') !!}</div>
        </div>
        <div class="small-offset-3 small-9 large-offset-3 large-8 cell">
            <input class="button" type="submit" value="{{ __('system.update') }}" />
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{
    Setting::get('system.google_maps_key') }}&libraries=places"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-locationpicker@0.1.12/dist/locationpicker.jquery.min.js"></script>
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

        $('#map').locationpicker({
            inputBinding: {
                latitudeInput: $('#event_location_lat'),
                longitudeInput: $('#event_location_long'),
                locationNameInput: $('#event_location_name')
            },
            radius: 0,
        });
    });
</script>
@endpush