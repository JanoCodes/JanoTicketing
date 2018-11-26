@extends('layouts.app')

@section('title', __('system.account'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <h3>{{ __('system.account') }}</h3>
                <strong>{{ __('system.amount_outstanding') }}: </strong>
                {{ $account->full_amount_outstanding }}
            </div>
            <div class="col-sm-4 text-right">
                {{ $account->formatted_status }}
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ __('system.attendee') }}</th>
                <th>{{ __('system.type') }}</th>
                <th></th>
            </tr>
            </thead>
            @forelse ($user->attendees()->get() as $attendee)
                <tr>
                    <td class="attendee-view">
                        <strong>{{ $attendee->title }} {{ $attendee->first_name }} {{ $attendee->last_name }}</strong>
                    </td>
                    <td class="attendee-view">
                        <strong>{{ $attendee->ticket->name }}</strong><br />
                        <small>
                            {{ \Jano\Repositories\HelperRepository::getUserPrice($attendee->ticket->price, $user) }}
                        </small>
                    </td>
                    <td>
                        @widget('attendeeCancelAction', ['attendee' => $attendee])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">{{ __('system.no_attendee_exists') }}</td>
                </tr>
            @endforelse
        </table>
        <div class="modal modal-sm" id="cancel-attendees-container">
            <p class="lead text-alert">
                <strong>
                    {{ __('system.cancel_alert', ['attribute' => strtolower(__('system.attendee'))]) }}
                </strong><br />
                <small>{{ __('system.cancel_small') }}</small>
            </p>
            <form role="form" method="POST" action="#">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-warning">{{ __('system.continue') }}</button>
                <button type="button" class="btn btn-secondary" href="#" data-close>
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