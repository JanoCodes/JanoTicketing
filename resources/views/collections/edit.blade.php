@extends('layouts.app')

@section('title', __('system.collection_edit'))

@section('content')
    <div class="grid-x grid-padding-x">
        <div class="small-12 medium-10 large-9 cell">
            <h3>{{ __('system.collection_edit') }}</h3>
            <form role="form" method="POST" action="{{ route('collections.edit', $collection) }}" data-abide novalidate>
                <div class="grid-x">
                    @include('partials.error')
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="small-4 cell">
                        <label class="text-right middle{{ $errors->has('first_name') ? ' is-invalid-label' : '' }}">
                            {{ __('system.first_name') }}
                        </label>
                    </div>
                    <div class="small-8 cell">
                        <input type="text" name="first_name" id="first_name" pattern="text"
                               value="{{ old('first_name') ?? $collection->first_name }}" required>
                        @if ($errors->has('first_name'))
                            <span class="form-error">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="small-4 cell">
                        <label class="text-right middle{{ $errors->has('last_name') ? ' is-invalid-label' : '' }}">
                            {{ __('system.last_name') }}
                        </label>
                    </div>
                    <div class="small-8 cell">
                        <input type="text" name="last_name" id="last_name" pattern="text"
                               value="{{ old('last_name') ?? $collection->last_name }}" required>
                        @if ($errors->has('last_name'))
                            <span class="form-error">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="small-4 cell">
                        <label class="text-right middle{{ $errors->has('email') ? ' is-invalid-label' : '' }}">
                            {{ __('system.email') }}
                        </label>
                    </div>
                    <div class="small-8 cell">
                        <input type="email" name="email" id="email" pattern="email"
                               value="{{ old('email') ?? $collection->email }}" required>
                        @if ($errors->has('email'))
                            <span class="form-error">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="small-12 cell">
                        <button type="submit" class="button">{{ __('system.submit') }}</button>
                        <a class="button hollow" href="{{ url('/') }}">
                            {{ __('system.back') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection