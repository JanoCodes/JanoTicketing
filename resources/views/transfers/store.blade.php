@extends('layouts.app')

@section('title', __('system.ticket_transfer_request'))

@section('content')
<div class="grid-x grid-padding-x">
    <div class="small-12 cell">
        <h3>{{ __('system.transfer_created') }}</h3>
        <p>{{ __('system.transfer_created_details') }}</p>
        <table>
            <tr>
                <th>{{ __('system.type') }}</th>
                <td>{{ $transfer_request->attendee()->ticket()->name }}</td>
            </tr>
            <thead>
            <tr>
                <th colspan="2">{{ __('system.original_attendee') }}</th>
            </tr>
            </thead>
            <tr>
                <th>{{ __('system.full_name') }}</th>
                <td>
                    {{ $transfer_request->original_title }}&nbsp;{{ $transfer_request->original_first_name }}&nbsp;
                    {{ $transfer_request->original_last_name }}
                </td>
            </tr>
            <tr>
                <th>{{ __('system.email') }}</th>
                <td>{{ $transfer_request->original_email }}</td>
            </tr>
            <thead>
            <tr>
                <th colspan="2">{{ __('system.new_attendee') }}</th>
            </tr>
            </thead>
            <tr>
                <th>{{ __('system.full_name') }}</th>
                <td>
                    {{ $transfer_request->title }}&nbsp;{{ $transfer_request->first_name }}&nbsp;
                    {{ $transfer_request->last_name }}
                </td>
            </tr>
            <tr>
                <th>{{ __('system.email') }}</th>
                <td>{{ $transfer_request->email }}</td>
            </tr>
        </table>
        <a class="button hollow" href="{{ url('/') }}">
            {{ __('system.back') }}
        </a>
    </div>
</div>
@endsection