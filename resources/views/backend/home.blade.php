@extends('layouts.backend')

@section('title', __('system.home'))

@section('content')
<div class="clearfix">&nbsp;</div>
<div class="row dashboard" id="dashboard">
    <div class="col-sm-12 col-md-7 col-lg-9">
        @asyncWidget('backend.recentAttendees')
    </div>
    <div class="col-sm-12 col-md-5 col-lg-3">
        @asyncWidget('backend.attendeesCountBadge')
        @asyncWidget('backend.totalChargesBadge')
    </div>
</div>
@endsection