@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="small-10 small-centered large-6 columns">
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
                    <div class="row columns">
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

                    <div class="row column">
                        <div class="button-group stacked-for-small">
                            <button type="submit" class="button">
                                {{ __('system.send_password_reset_link') }}
                            </button>
                            <a class="button hollow" href="{{ route('login') }}">
                                {{ __('system.back') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
