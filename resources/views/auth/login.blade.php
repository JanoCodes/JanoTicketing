@extends('layouts.app')

@section('title', __('system.login'))

@section('content')
    <div class="grid-x padding-gutters">
        <div class="small-10 small-offset-1 large-6 large-offset-3 cell">
            <div class="callout">
                <h3>{{ __('system.login') }}</h3>
                <form role="form" method="POST" action="{{ route('login') }}" data-abide novalidate>
                    @include('partials.error')
                    {{ csrf_field() }}
                    <div class="grid-x cell">
                        <label{{ $errors->has('email') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.email') }}
                            <input id="email" type="email" pattern="email"
                                   {{ $errors->has('email') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="form-error is-visible">
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

                    <div class="grid-x cell{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label{{ $errors->has('password') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.password') }}
                            <input id="password" type="password"
                                   {{ $errors->has('password') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="password" required>
                            @if ($errors->has('password'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @else
                                <span class="form-error">
                                    <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.password'))])
                                    }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="grid-x cell">
                        <label for="remember">
                            <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            {{ __('system.remember_me') }}
                        </label>
                    </div>

                    <div class="grid-x cell">
                        <button type="submit" class="button">{{ __('system.login') }}</button>
                        <a class="button hollow" href="{{ route('register') }}">
                            {{ __('system.register') }}
                        </a>
                        <a class="button hollow" href="{{ route('password.request') }}">
                            {{ __('system.forgot_your_password') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
