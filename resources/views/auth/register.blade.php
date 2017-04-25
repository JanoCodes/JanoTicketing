@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="small-10 small-centered large-6 columns">
            <div class="callout">
                <h3>{{ __('system.register') }}</h3>
                <form role="form" method="POST" action="{{ route('register') }}" data-abide>
                    @include('partials.error')
                    {{ csrf_field() }}
                    <div class="row columns">
                        <label{{ $errors->has('first_name') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.first_name') }}
                            <input id="first_name" type="text"
                                {{ $errors->has('first_name') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                name="first_name" value="{{ old('first_name') }}" required autofocus>
                            @if ($errors->has('first_name'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="row columns">
                        <label{{ $errors->has('last_name') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.last_name') }}
                            <input id="last_name" type="text"
                                   {{ $errors->has('last_name') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="last_name" value="{{ old('last_name') }}" required autofocus>
                            @if ($errors->has('last_name'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="row columns">
                        <label{{ $errors->has('email') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.email') }}
                            <input id="email" type="email" pattern="email"
                                   {{ $errors->has('email') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="row columns">
                        <label{{ $errors->has('password') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.password') }}
                            <input id="password" type="password"
                                   {{ $errors->has('email') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="password" required>
                            @if ($errors->has('password'))
                                <span class="form-error">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="row columns">
                        <label{{ $errors->has('password_confirmation') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.confirm_password') }}
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   data-equalto="password" required>
                            @if ($errors->has('password_confirmation'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="row columns">
                        <button type="submit" class="button">
                            {{ __('system.register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
