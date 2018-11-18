@extends('layouts.app')

@section('title', __('system.register'))

@section('content')
    <div class="row">
        <div class="col-sm-10 offset-sm-1 col-lg-6 offset-lg-3">
            <div class="card">
                <div class="card-body">
                    <h3>{{ __('system.register') }}</h3>
                    @include('partials.error')
                    {!! form($form) !!}
                </div>
                <div class="card-footer text-right">
                    <a class="card-link" href="{{ route('login') }}">
                        {{ __('system.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
