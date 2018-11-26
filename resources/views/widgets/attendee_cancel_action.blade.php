@if (!$attendee->paid)
    <button type="button" class="btn btn-danger btn-sm cancel-ticket" data-cancel
            data-cancel-object="attendees" data-cancel-object-id="{{ $attendee->id }}">
        {{ __('system.attendee_cancel') }}
    </button>
@endif