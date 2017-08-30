@extends('layouts.backend')

@section('title', __('system.user'))

@section('content')
    <div class="grid-x grid-padding-x cell">
        <div class="grid-x text-wrap">
            <div class="auto cell">
                <h3>{{ $user->title }} {{ $user->first_name }} {{ $user->last_name }}</h3>
                {{ $user->email }}<br />
                {{ $user->group()->first()->name }}<br />
                <strong>{{ __('system.amount_outstanding') }}:</strong> {{ $account->full_amount_outstanding }}
            </div>
            <div class="shrink cell">
                {{ $account->formatted_status }}
            </div>
        </div>

        <table>
            <thead>
            <tr>
                <th>{{ __('system.attendee') }}</th>
                <th>{{ __('system.email') }}</th>
                <th>{{ __('system.type') }}</th>
                <th></th>
            </tr>
            </thead>
            @foreach ($user->attendees()->get() as $attendee)
                <tr>
                    <td>
                        <strong>{{ $attendee->title }} {{ $attendee->first_name }} {{ $attendee->last_name }}</strong>
                    </td>
                    <td>
                        {{ $attendee->email }}
                    </td>
                    <td>
                        <strong>{{ $attendee->ticket->name }}</strong>
                    </td>
                    <td>
                        <a class="button tiny warning" href="{{ route('attendees.edit', ['attendee' => $attendee]) }}">
                            {{ __('system.transfer_create') }}
                        </a>
                        @if (!$attendee->paid)
                            <a class="button tiny danger cancel-ticket" data-cancel data-cancel-object="attendees"
                               data-cancel-object-id="{{ $attendee->id }}" href="#">
                                {{ __('system.attendee_cancel') }}
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        @if ($account->charges()->count() !== 0)
            <strong class="text-wrap">{{ __('system.charges') }}</strong>
            <table>
                <thead>
                <tr>
                    <th>{{ __('system.amount_due') }}</th>
                    <th>{{ __('system.description') }}</th>
                    <th>{{ __('system.payment_due') }}</th>
                </tr>
                </thead>
                @foreach ($account->charges()->get() as $charge)
                    <tr>
                        <td>{{ $charge->full_amount }}</td>
                        <td>{{ $charge->description }}</td>
                        <td>{{ $charge->due_at->toDateString() }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        @if ($account->payments()->count() !== 0)
            <strong class="text-alert">{{ __('system.payments') }}</strong>
            <table>
                <thead>
                <tr>
                    <th>{{ __('system.date_credited') }}</th>
                    <th>{{ __('system.amount_paid') }}</th>
                    <th>{{ __('system.method') }}</th>
                    <th>{{ __('system.reference') }}</th>
                </tr>
                </thead>
                @foreach ($account->payments()->get() as $payment)
                    <tr>
                        <td>{{ $payment->made_at->toDateString() }}</td>
                        <td>{{ $payment->full_amount }}</td>
                        <td>{{ __('system.payment_methods.' . $payment->method) }}</td>
                        <td>{{ $payment->reference }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        @if ($user->transferRequests()->count() !== 0)
            <strong>{{ __('system.ticket_transfer_request') }}</strong>
            <table>
                <thead>
                <tr>
                    <th>{{ __('system.original_attendee') }}</th>
                    <th>{{ __('system.new_attendee') }}</th>
                    <th>{{ __('system.status') }}</th>
                    <th></th>
                </tr>
                </thead>
                @foreach ($user->transferRequests()->get() as $ticket_transfer)
                    <tr>
                        <td>{{ $ticket_transfer->original_full_name }}</td>
                        <td>{{ $ticket_transfer->full_name }}</td>
                        <td>{{ $ticket_transfer->formatted_status }}</td>
                        <td>
                            @if (!$ticket_transfer->completed)
                                <a class="button tiny secondary"
                                   href="{{ url('transfers/' . $ticket_transfer->id . '/edit') }}">
                                    {{ __('system.transfer_edit') }}
                                </a>&nbsp;
                                <a class="button tiny danger cancel-transfer" data-cancel data-cancel-object="transfers"
                                   data-cancel-object-id="{{ $ticket_transfer->id }}" href="#">
                                    {{ __('system.transfer_cancel') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
        <div class="text-wrap">
            <a class="button primary" href="{{ route('backend.users.index') }}">{{ __('system.back') }}</a>
        </div>
    </div>
@endsection