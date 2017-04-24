@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="small-10 small-centered large-6 column">
            <div class="callout">
                <h3>{{ __('system.login') }}</h3>
                <form role="form" method="POST" action="{{ route('login') }}" data-abide>
                    @include('partials.error')
                    {{ csrf_field() }}
                    <div class="row columns">
                        <label{{ $errors->has('email') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.email') }}
                            <input id="email" type="email" pattern="email"
                                   {{ $errors->has('email') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="row columns{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label{{ $errors->has('password') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.password') }}
                            <input id="password" type="password"
                                   {{ $errors->has('password') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="password" required>
                            @if ($errors->has('password'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="row columns">
                        <div class="checkbox">
                            <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">{{ __('system.remember_me') }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-6 columns">
                            <button type="submit" class="button">{{ __('system.login') }}</button>
                        </div>
                        <div class="small-6 columns">
                            <a class="button" href="{{ route('password.request') }}">
                                {{ __('system.forgot_your_password') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
