@extends('layouts.backend')

@section('title', __('system.home'))

@section('content')
<div class="clearfix">&nbsp;</div>
<div class="grid-x grid-padding-x dashboard" id="dashboard">
    <div class="small-12 medium-7 large-9 cell">
        @asyncWidget('backend.recentAttendees')
    </div>
    <div class="small-12 medium-5 large-3 cell">
        @asyncWidget('backend.attendeesCountBadge')
        @asyncWidget('backend.totalChargesBadge')
    </div>
</div>
@endsection