@if (!$attendee->paid)
    <button type="button" class="button tiny danger cancel-ticket" data-cancel
            data-cancel-object="attendees" data-cancel-object-id="{{ $attendee->id }}">
        {{ __('system.attendee_cancel') }}
    </button>
@endif