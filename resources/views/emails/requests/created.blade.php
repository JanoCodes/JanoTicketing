@component('mail::message')
# {!! __('system.request_created') !!}

{!! __('email.opening', ['user' => $notifiable->first_name]) !!}

{!! __('email.request_created_message', ['event' => Setting::get('event.name')]) !!}

@component('mail::table')
|                              | {!! __('system.type') !!}           |
| ---------------------------- | -----------------------------------:|
| {!! $request->title !!} {!! $request->first_name !!} {!! $request->last_name !!} | {!! $request->ticket->name !!}<br />{!! $request->ticket->full_price !!} |
@endcomponent

{!! __('email.request_created_closing', ['event' => Setting::get('event.name')]) !!}

{!! __('email.closing', ['event' => Setting::get('event.name')]) !!}
@endcomponent
