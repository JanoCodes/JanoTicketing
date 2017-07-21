<div class="reveal" id="login-modal" data-reveal>
    <button class="close-button" aria-label="Close" type="button" data-close>
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="grid-x grid-padding-x">
        <div class="small-12 medium-6 cell">
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
                                <strong>
                                    {{ __('validation.email', ['attribute' => strtolower(__('system.email'))]) }}
                                </strong>
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
                    <a class="button clear" href="{{ route('password.request') }}">
                        {{ __('system.forgot_your_password') }}
                    </a>
                </div>
            </form>
        </div>
        <div class="small-12 medium-6 cell">
            <h3>{{ __('system.register') }}</h3>
            <form role="form" method="POST" action="{{ route('register') }}" data-abide novalidate>
                @include('partials.error')
                {{ csrf_field() }}
                <div class="grid-x cell">
                    <label{{ $errors->has('first_name') ? ' class="is-invalid-label"' : '' }}>
                        {{ __('system.first_name') }}
                        <input id="first_name" type="text"
                               {{ $errors->has('first_name') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                               name="first_name" value="{{ old('first_name') }}" required autofocus>
                        @if ($errors->has('first_name'))
                            <span class="form-error is-visible">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                        @else
                            <span class="form-error">
                                    <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.first_name'))])
                                    }}</strong>
                                </span>
                        @endif
                    </label>
                </div>

                <div class="grid-x cell">
                    <label{{ $errors->has('last_name') ? ' class="is-invalid-label"' : '' }}>
                        {{ __('system.last_name') }}
                        <input id="last_name" type="text"
                               {{ $errors->has('last_name') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                               name="last_name" value="{{ old('last_name') }}" required autofocus>
                        @if ($errors->has('last_name'))
                            <span class="form-error is-visible">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                        @else
                            <span class="form-error">
                                    <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.last_name'))])
                                    }}</strong>
                                </span>
                        @endif
                    </label>
                </div>

                <div class="grid-x cell">
                    <label{{ $errors->has('email') ? ' class="is-invalid-label"' : '' }}>
                        {{ __('system.email') }}
                        <input id="email" type="email" pattern="email"
                               {{ $errors->has('email') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                               name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="form-error is-visible">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @else
                            <span class="form-error">
                                    <strong>{{ __('validation.email', ['attribute' => strtolower(__('system.email'))
                                    ]) }}</strong>
                                </span>
                        @endif
                    </label>
                </div>

                <div class="grid-x cell">
                    <label{{ $errors->has('phone') ? ' class="is-invalid-label"' : '' }}>
                        {{ __('system.phone') }}
                        <input id="phone" type="text" pattern="phone"
                               {{ $errors->has('phone') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                               name="phone" value="{{ old('phone') }}" required>
                        @if ($errors->has('phone'))
                            <span class="form-error is-visible">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @else
                            <span class="form-error">
                                    <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.phone'))
                                    ]) }}</strong>
                                </span>
                        @endif
                    </label>
                </div>

                <div class="grid-x cell">
                    <label{{ $errors->has('password') ? ' class="is-invalid-label"' : '' }}>
                        {{ __('system.password') }}
                        <input id="password" type="password"
                               {{ $errors->has('email') ? 'class="is-invalid-input" aria-invalid ' : '' }}
                               name="password" required>
                        @if ($errors->has('password'))
                            <span class="form-error">
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
                    <label{{ $errors->has('password_confirmation') ? ' class="is-invalid-label"' : '' }}>
                        {{ __('system.confirm_password') }}
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               data-equalto="password" required>
                        @if ($errors->has('password_confirmation'))
                            <span class="form-error is-visible">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                        @else
                            <span class="form-error">
                                    <strong>{{ __('validation.confirmed', [
                                        'attribute' => strtolower(__('system.password'))
                                    ])}}</strong>
                                </span>
                        @endif
                    </label>
                </div>

                <div class="grid-x cell">
                    <div class="button-group stacked-for-small">
                        <button type="submit" class="button">
                            {{ __('system.register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>