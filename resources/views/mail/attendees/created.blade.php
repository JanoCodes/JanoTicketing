@component('mail::message')
# {!! __('system.order_confirmed') !!}

{!! __('email.opening', ['name' => $notifiable->first_name]) !!}

{!! __('email.order_created_message', ['event' => Setting::get('event.name')]) !!}

@component('mail::table')
|                              | {!! __('system.price') !!}                                      |
| ---------------------------- | ---------------------------------------------------------------:|
@foreach ($attendees as $attendee)
| {!! $attendee->title !!} {!! $attendee->first_name !!} {!! $attendee->last_name !!}<br />__{!!
$attendee->ticket->name !!}__ | {!! Helper::getUserPrice($attendee->ticket->price, $account->user()->first(), true)
!!} |
@endforeach
|                              | **{!! Setting::get('payment.currency') !!}{!! $amount_due !!}** |
@endcomponent

{!! __('email.bank_payment_message', ['balance' => $amount_due, 'deadline' =>
    Setting::get('payment.deadline')]) !!}

@component('mail::table')
| {!! __('email.bank_account_name') !!}      | {!! Setting::get('payment.account.name') !!}      |
|:------------------------------------------ |:------------------------------------------------- |
| {!! __('email.bank_account_sort_code') !!} | {!! Setting::get('payment.account.sort_code') !!} |
| {!! __('email.bank_account_number') !!}    | {!! Setting::get('payment.account.number') !!}    |
| {!! __('email.bank_payment_reference') !!} | {!! $account->payment_reference !!}               |
@endcomponent

{!! __('email.order_created_closing', ['event' => Setting::get('event.name')]) !!}

{!! __('email.closing', ['event' => Setting::get('event.name')]) !!}
@endcomponent