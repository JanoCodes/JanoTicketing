@extends('layouts.backend')

@section('title', __('system.create_type'))

@section('content')
<div class="clearfix">&nbsp;</div>
@include('partials.error')
{!! form($form) !!}
@endsection
