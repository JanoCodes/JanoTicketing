@component('mail::message')
# {!! __('system.transfer_created') !!}

{!! __('email.opening', ['user' => __('email.generic_user')]) !!}

{!! __('email.transfer_primary_message', [
    'original' => $transfer->old_title . ' ' . $transfer->old_first_name . ' ' . $transfer->old_last_name,
    'class' => $transfer->attendee->ticket->name
]) !!}

@component('mail::button', ['url' => route('transfers.associate', ['transfer' => $transfer])])
    {!! __('email.transfer_create_account') !!}
@endcomponent

{!! __('email.transfer_primary_message2', [
    'original' => $transfer->old_title . ' ' . $transfer->old_first_name . ' ' . $transfer->old_last_name
]) !!}

{!! __('email.transfer_primary_closing', ['event' => Setting::get('event.name')]) !!}

{!! __('email.closing', ['event' => Setting::get('event.name')]) !!}
@endcomponent