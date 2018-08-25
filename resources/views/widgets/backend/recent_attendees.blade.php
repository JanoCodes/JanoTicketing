<table>
    <thead>
    <tr>
        <td colspan="2">
            <a href="{{ route('backend.attendees.index') }}">
                {{ __('system.recent_attendees') }}
            </a>
        </td>
    </tr>
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