@extends('layouts.app')

@section('content')
    <div class="row columns">
        <h2>{{ Setting::get('system.title') }}</h2>
        {{ __('system.welcome', ['title' => Setting::get('system.title')]) }}
        <div class="button-group stacked-for-small large">
            @if (Setting::get('register.methods.oauth.active'))
                <a class="button hollow" href="#">
                    {{ Setting::get('register.methods.oauth.name') }}
                </a>
            @endif
            @if (Setting::get('register.methods.generic.active'))
                <a class="button hollow" href="{{ route('login') }}">
                    {{ Setting::get('register.methods.generic.name') }}
                </a>
            @endif
        </div>
    </div>
@endsection
