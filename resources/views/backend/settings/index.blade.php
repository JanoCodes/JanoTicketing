@extends('layouts.backend')

@section('title', __('system.settings'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form role="form" action="{{ route('backend.settings.update') }}" data-abide novalidate>
    <div class="grid-x grid-padding-x">
        @include('partials.error')
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle"><strong>{{ __('system.title') }}</strong></label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="text" name="system.title" id="system_title" pattern="text"
                value="{{ Setting::get('system.title') }}" required>
        </div>
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
            <input type="text" name="event.date" id="event_date" pattern="text"
                   value="{{ Setting::get('event.date') }}" required>
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
            <textarea rows="3" name="agreement" id="agreement" required>{!! Setting::get('agreement') !!}</textarea>
        </div>
        <div class="small-offset-3 small-9 large-offset-3 large-8 cell">
            <input class="button" type="submit" value="{{ __('system.update') }}" />
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#event_date').flatpickr({
        altFormat: 'j M Y h:i K',
        altInput: true,
        dateFormat: 'd/m/Y',
        enableTime: true,
        mode: 'range'
    });
</script>
@endpush