@if ($user->transferRequests()->count() !== 0)
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
                        <a class="button tiny danger cancel-transfer" data-cancel
                           data-cancel-object="transfers" data-cancel-object-id="{{ $ticket_transfer->id }}">
                            {{ __('system.transfer_cancel') }}
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    <div class="small reveal" id="cancel-transfers-container" data-reveal>
        <p class="lead text-alert">
            <strong>
                {{ __('system.cancel_alert', [
                    'attribute' => strtolower(__('system.ticket_transfer_request'))
                ]) }}
            </strong><br />
            <small>{{ __('system.cancel_small') }}</small>
        </p>
        <form role="form" method="POST" action="#">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="alert button">{{ __('system.continue') }}</button>
            <button type="button" class="secondary button" href="#" data-close>
                {{ __('system.back') }}
            </button>
        </form>
    </div>
@endif