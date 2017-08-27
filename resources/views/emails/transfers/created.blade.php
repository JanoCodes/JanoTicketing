@component('mail::message')
# {!! __('system.transfer_created') !!}

{!! __('email.opening', ['user' => $notifiable->first_name]) !!}

{!! __('email.transfer_created_message', [
    'original' => $transfer->old_title . ' ' . $transfer->old_first_name . ' ' . $transfer->old_last_name,
    'new' => $transfer->title . ' ' . $transfer->first_name . ' ' . $transfer->last_name,
    'class' => $transfer->attendee->ticket->name
]) !!}

@component('mail::button', ['url' => route('transfers.confirm', ['transfer' => $transfer,
    'token' => $transfer->confirmation_code])])
{!! __('email.transfer_request_confirm') !!}
@endcomponent

{!! __('email.transfer_created_message2') !!}

{!! __('email.transfer_created_closing', ['event' => Setting::get('event.name')]) !!}

{!! __('email.closing', ['event' => Setting::get('event.name')]) !!}
@endcomponent