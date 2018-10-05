@component('mail::message')
# {!! __('system.order_confirmed') !!}

{!! __('email.opening', ['user' => $notifiable->first_name]) !!}

{!! __('email.order_created_message', ['event' => Setting::get('event.name')]) !!}

@component('mail::table')
|                              | {!! __('system.price') !!}          |
| ---------------------------- | -----------------------------------:|
@foreach ($attendees as $attendee)
| {!! $attendees->title !!} {!! $attendees->first_name !!} {!! $attendees->last_name !!}<br />__{!! $attendee->ticket->name !!}__ | {!! $attendee->ticket->full_price !!} |
@endforeach
|                              | **{!! $order->amount_due !!}**      |
@endcomponent

{!! __('email.order_created_closing', ['event' => Setting::get('event.name')]) !!}

{!! __('email.closing', ['event' => Setting::get('event.name')]) !!}
@endcomponent