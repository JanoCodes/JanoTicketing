@extends('layouts.app')

@section('title', __('system.account'))

@section('content')
    <div class="grid-container fluid">
        <div class="grid-x">
            <div class="small-8 cell">
                <h3>{{ __('system.account') }}</h3>
                <strong>{{ __('system.amount_outstanding') }}: </strong>
                {{ $account->full_amount_outstanding }}
            </div>
            <div class="small-4 cell align-right">
                {{ $account->formatted_status }}
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <table>
            <thead>
            <tr>
                <th>{{ __('system.attendee') }}</th>
                <th>{{ __('system.type') }}</th>
                <th></th>
            </tr>
            </thead>
            @forelse ($user->attendees()->get() as $attendee)
                <tr>
                    <td>
                        <strong>{{ $attendee->title }} {{ $attendee->first_name }} {{ $attendee->last_name }}</strong>
                    </td>
                    <td>
                        <strong>{{ $attendee->ticket->name }}</strong><br />
                        <small>
                            {{ \Jano\Repositories\HelperRepository::getUserPrice($attendee->ticket->price, $user) }}
                        </small>
                    </td>
                    <td>
                        <a class="button tiny warning" href="{{ route('attendees.edit', ['attendee' => $attendee]) }}">
                            {{ __('system.transfer_create') }}
                        </a>
                        @widget('attendeeCancelAction', ['attendee' => $attendee])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">{{ __('system.no_attendee_exists') }}</td>
                </tr>
            @endforelse
        </table>
        <div class="small reveal" id="cancel-attendees-container" data-reveal>
            <p class="lead text-alert">
                <strong>
                    {{ __('system.cancel_alert', ['attribute' => strtolower(__('system.attendee'))]) }}
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
        @widget('accountPayments')
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('[data-cancel]').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();

                const object = $(this).data('cancel-object');
                $('#cancel-' + object + '-container')
                    .foundation('open')
                    .children('form')
                    .attr('action', object + '/' + $(this).data('cancel-object-id'));
            })
        });
    </script>
@endpush