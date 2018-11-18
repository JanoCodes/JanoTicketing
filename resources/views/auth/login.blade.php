@extends('layouts.app')

@section('title', __('system.login'))

@section('content')
    <div class="row">
        <div class="col-sm-10 offset-sm-1 col-lg-6 offset-lg-3">
            <div class="card">
                <div class="card-body">
                    <h3>{{ __('system.login') }}</h3>
                    @include('partials.error')
                    {!! form($form) !!}
                </div>
                <div class="card-footer text-right">
                    <a class="card-link" href="{{ route('register') }}">
                        {{ __('system.register') }}
                    </a>
                    <a class="card-link" href="{{ route('password.request') }}">
                        {{ __('system.forgot_your_password') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
