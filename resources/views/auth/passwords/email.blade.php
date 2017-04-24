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

                <form role="form" method="POST" action="{{ route('password.email') }}" data-abide>
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
                            @endif
                        </label>
                    </div>

                    <div class="row column">
                        <button type="submit" class="btn btn-primary">
                            {{ __('system.send_password_reset_link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
