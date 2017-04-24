@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="small-10 small-centered large-6 columns">
            <div class="callout">
                <h3>{{ __('system.reset_password') }}</h3>

                @if (session('status'))
                    <div class="alert callout" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form role="form" method="POST" action="{{ route('password.request') }}" data-abide>
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="row columns">
                        <label{{ $errors->has('email') ? ' class="is-invalid-label"' : '' }}>
                            {{ __('system.email') }}
                            <input id="email" type="email" pattern="email"
                                   {{ $errors->has('email') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                                   name="email" value="{{ $email or old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="row columns">
                        <label for="password" class="col-md-4 control-label">
                            {{ __('system.new_password') }}
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
                        <label>
                            {{ __('system.confirm_password') }}
                            <input id="password_confirmation" type="password"
                                   {{ $errors->has('password_confirmation') ? 'class="is-invalid-input" aria-invalid '
                                   : '' }}name="password_confirmation" data-match="password" required>

                            @if ($errors->has('password_confirmation'))
                                <span class="form-error is-visible">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </label>
                    </div>

                    <div class="row columns">
                        <button type="submit" class="button">
                            {{ __('system.reset_password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
