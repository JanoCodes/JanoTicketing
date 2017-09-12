@extends('layouts.backend')

@section('title', __('system.create_group'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form id="form" role="form" method="POST" action="{{ route('backend.groups.store') }}">
    <div class="grid-x grid-padding-x">
        @include('partials.error')
        {{ csrf_field() }}
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('name') ? ' is-invalid-label' : '' }}">
                {{ __('system.group') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="text" name="name" id="name" required>
            @if ($errors->has('name'))
                <span class="form-error">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('slug') ? ' is-invalid-label' : '' }}">
                {{ __('system.slug') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="text" name="slug" id="slug" required>
            @if ($errors->has('slug'))
                <span class="form-error">
                    <strong>{{ $errors->first('slug') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('can_order_at') ? ' is-invalid-label' : '' }}">
                {{ __('system.ticket_order_begins') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="text" name="can_order_at" id="can_order_at" required>
            @if ($errors->has('can_order_at'))
                <span class="form-error">
                    <strong>{{ $errors->first('can_order_at') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('ticket_limit') ? ' is-invalid-label' : '' }}">
                {{ __('system.ticket_limit') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="number" name="ticket_limit" id="ticket_limit" pattern="integer" required>
            @if ($errors->has('ticket_limit'))
                <span class="form-error">
                    <strong>{{ $errors->first('ticket_limit') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('surcharge') ? ' is-invalid-label' : '' }}">
                {{ __('system.surcharge') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <div class="input-group">
                <span class="input-group-label">{{ Setting::get('payment.currency') }}</span>
                <input name="surcharge" id="surcharge" class="input-group-field" type="number"
                       pattern="integer" required>
            </div>
            @if ($errors->has('surcharge'))
                <span class="form-error">
                    <strong>{{ $errors->first('surcharge') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('right_to_buy') ? ' is-invalid-label' : '' }}">
                {{ __('system.right_to_buy') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <div class="input-group">
                <input name="right_to_buy" id="right_to_buy" class="input-group-field"
                       type="number" pattern="integer" required>
                <span class="input-group-label">{{ __('system.ticket_s') }}</span>
            </div>
            @if ($errors->has('right_to_buy'))
                <span class="form-error">
                    <strong>{{ $errors->first('right_to_buy') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-offset-3 small-9 large-8 cell">
            <a class="button warning" href="{{ route('backend.groups.index') }}">{{ __('system.back') }}</a>
            <button class="button" type="submit">{{ __('system.submit') }}</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#can_order_at').flatpickr({
            altFormat: 'j M Y h:i K',
            altInput: true,
            dateFormat: 'd/m/Y',
            enableTime: true
        });
    });
</script>
@endpush
