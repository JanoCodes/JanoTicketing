<div class="card">
    <div class="card-header">
        <a class="card-title font-weight-bold" href="{{ route('backend.attendees.index') }}">
            {{ __('system.recent_attendees') }}
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table mb-1">
            <thead>
            <tr>
                <th>{{ __('system.full_name') }}</th>
                <th>{{ __('system.type') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($attendees as $attendee)
                <tr>
                    <td>{{ $attendee->title }} {{ $attendee->first_name }} {{ $attendee->last_name }}</td>
                    <td>{{ $attendee->ticket->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>