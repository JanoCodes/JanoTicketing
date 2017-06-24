@extends('layouts.app')

@section('title', __('system.welcome'))

@section('content')
    <div class="grid-x padding-gutters">
        <div class="cell">
            <h2>{{ Setting::get('system.title') }}</h2>
            {{ __('system.welcome_message', ['title' => Setting::get('system.title')]) }}
        </div>
    </div>
    @include('auth.modal')
@endsection
