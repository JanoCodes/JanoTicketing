@extends('layouts.backend')

@section('title', __('system.create_type'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form id="form" role="form" method="POST" action="{{ route('backend.tickets.store') }}">
    <div class="grid-x grid-padding-x">
        @include('partials.error')
        {{ csrf_field() }}
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('name') ? ' is-invalid-label' : '' }}">
                {{ __('system.type') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="text" name="name" id="name" required>
            @if ($errors->has('name'))
                <span class="form-error">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('price') ? ' is-invalid-label' : '' }}">
                {{ __('system.price') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <div class="input-group">
                <span class="input-group-label">{{ Setting::get('payment.currency') }}</span>
                <input name="amount" id="amount" class="input-group-field" type="number" pattern="integer"
                       required>
            </div>
            @if ($errors->has('price'))
                <span class="form-error">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-offset-3 small-9 large-8 cell">
            <a class="button warning" href="{{ route('backend.tickets.index') }}">{{ __('system.back') }}</a>
            <button class="button" type="submit">{{ __('system.submit') }}</button>
        </div>
    </div>
</form>
@endsection
