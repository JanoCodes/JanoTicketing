@extends('layouts.app')

@section('title', __('system.reset_password'))

@section('content')
    <div class="grid-x padding-gutters">
        <div class="small-10 small-offset-1 large-6 large-offset-3 cell">
            <div class="callout">
                <h3>{{ __('system.reset_password') }}</h3>

                @if (session('status'))
                    <div class="alert callout" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form role="form" method="POST" action="{{ route('password.request') }}" data-abide novalidate>
                    @include('partials.error')
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="grid-x cell">
                        <label{{ $errors->has('email') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.email') }}
                            <input id="email" type="email" pattern="email"
                                   {{ $errors->has('email') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="email" value="{{ $email or old('email') }}" required autofocus>
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

                    <div class="grid-x cell">
                        <label{{ $errors->has('password') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.new_password') }}
                            <input id="password" type="password"
                                   {{ $errors->has('password') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="password" required>

                            @if ($errors->has('password'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @else
                                <span class="form-error">
                                    <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.new_password'))])
                                    }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="grid-x cell">
                        <label{{ $errors->has('password_confirmation') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.confirm_password') }}
                            <input id="password_confirmation" type="password"
                                   {{ $errors->has('password_confirmation') ? 'class="is-invalid-input" aria-invalid '
                                   : '' }}name="password_confirmation" data-equalto="password" required>

                            @if ($errors->has('password_confirmation'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @else
                                <span class="form-error">
                                    <strong>{{ __('validation.confirmedd', ['attribute' => strtolower(__('system.new_password'))])
                                    }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="grid-x cell">
                        <button type="submit" class="button">
                            {{ __('system.reset_password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
