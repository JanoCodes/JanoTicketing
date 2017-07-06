@extends('layouts.app')

@section('title', __('system.reset_password'))

@section('content')
    <div class="grid-x padding-gutters">
        <div class="small-10 small-offset-1 large-6 large-offset-3 cell">
            <div class="callout">
                <h3>{{ __('system.reset_password') }}</h3>
                @if (session('status'))
                    <div class="callout alert" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form role="form" method="POST" action="{{ route('password.email') }}" data-abide novalidate>
                    @include('partials.error')
                    {{ csrf_field() }}
                    <div class="grid-x cell">
                        <label>
                            {{ __('system.email') }}
                            <input id="email" type="email" pattern="email"
                                   {{ $errors->has('email') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="form-error">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @else
                                <span class="form-error">
                                    <strong>{{ __('validation.email', ['attribute' => strtolower(__('system.email'))])
                                    }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="grid-x cell">
                        <button type="submit" class="button">
                            {{ __('system.send_password_reset_link') }}
                        </button>
                        <a class="button hollow" href="{{ route('login') }}">
                            {{ __('system.back') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
