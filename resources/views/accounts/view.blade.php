@extends('layouts.app')

@section('title', __('system.account'))

@section('content')
    <div class="grid-x grid-padding-x cell">
        <h3>{{ __('system.acount') }}</h3>
        <div class="grid-x">
            <div class="small-8 cell">{{ Helper::getFullPrice($account->amount_due) }}</div>
            <div class="small-4 cell align-right">
                {{ $account->formatted_status }}
            </div>
        </div>

        <table>
            <thead>
            <tr>
                <th>{{ __('system.attendee') }}</th>
                <th>{{ __('system.type') }}</th>
                <th></th>
            </tr>
            </thead>
            @foreach ($user->attendees() as $attendee)
            <tr>
                <td>
                    <h4>{{ $attendee->title }} {{ $attendee->first_name }} {{ $attendee->last_name }}</h4>
                </td>
                <td>
                    <h4>{{ $attendee->ticket->name }}</h4>
                    <small>{{ $attendee->ticket->full_price }}</small>
                </td>
                <td>
                    <a href="{{ url('attendee/' . $attendee->id . '/edit') }}">{{ __('system.transfer_create') }}</a>
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

        @if ($account->payments()->count() !== 0)
            <h3>{{ __('system.payments') }}</h3>
            <table>
                <thead>
                <tr>
                    <th>{{ __('system.date_credited') }}</th>
                    <th>{{ __('system.amount_paid') }}</th>
                    <th>{{ __('system.method') }}</th>
                    <th>{{ __('system.reference') }}</th>
                </tr>
                </thead>
                @foreach ($account->payments() as $payment)
                <tr>
                    <td>{{ $payment->made_at->toDateString() }}</td>
                    <td>{{ Helper::getFullPrice($payment->amount) }}</td>
                    <td>{{ __('system.payment_methods.' . $payment->method) }}</td>
                    <td>{{ $payment->reference }}</td>
                </tr>
                @endforeach
            </table>
        @endif

        @if ($user->transfer_requests()->count() !== 0)
            <h3>{{ __('system.ticket_transfer_request') }}</h3>
            <table>
                <thead>
                <tr>
                    <th>{{ __('system.original_attendee') }}</th>
                    <th>{{ __('system.new_attendee') }}</th>
                    <th>{{ __('system.status') }}</th>
                    <th></th>
                </tr>
                </thead>
                @foreach ($user->transfer_requests() as $ticket_transfer)
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
    </div>
    <div class="small reveal" id="cancel-attendees-container" data-reveal>
        <p class="lead text-alert">
            <strong>
                {{ __('system.cancel_alert', ['attribute' => strtolower('system.attendee')]) }}
            </strong><br />
            <small>{{ __('system.cancel_small') }}</small>
        </p>
        <form role="form" method="POST" action="#">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="button" class="alert button">{{ __('system.continue') }}</button>
            <button class="secondary button" href="#" data-close>{{ __('system.back') }}</button>
        </form>
    </div>
    <div class="small reveal" id="cancel-transfers-container" data-reveal>
        <p class="lead text-alert">
            <strong>
                {{ __('system.cancel_alert', ['attribute' => strtolower('system.ticket_transfer_request')]) }}
            </strong><br />
            <small>{{ __('system.cancel_small') }}</small>
        </p>
        <form role="form" method="POST" action="#">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="button" class="alert button">{{ __('system.continue') }}</button>
            <button class="secondary button" href="#" data-close>{{ __('system.back') }}</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('[data-cancel]').each(function() {
            this.on('click', function(e) {
                e.preventDefault();

                var object = this.data('cancel-object');
                $('#cancel-' + object + '-container')
                    .foundation('open')
                    .children('form')
                    .attr('action', object + '/' + this.data('cancel-object-id'));

            })
        });
    </script>
@endpush