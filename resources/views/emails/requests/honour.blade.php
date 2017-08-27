@component('mail::message')
# {!! __('system.request_honour_title') !!}

{!! __('email.opening', ['user' => $notifiable->first_name]) !!}

{!! __('email.request_honour_message', ['event' => Setting::get('event.name'), 'class' => $ticket->name]) !!}

@component('mail::button', ['url' => route('requests.index')])
{!! __('email.request_honour_commit') !!}
@endcomponent

{!! __('email.request_honour_closing', ['event' => Setting::get('event.name')]) !!}

{!! __('email.closing', ['event' => Setting::get('event.name')]) !!}
@endcomponent