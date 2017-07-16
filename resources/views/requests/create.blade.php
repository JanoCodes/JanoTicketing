@extends('layouts.app')

@section('title', __('system.request_create'))

@section('content')
    <div class="grid-x padding-gutters">
        <div class="small-12 cell">
            <h3>{{ __('system.transfer_create') }}</h3>
            <form role="form" method="POST" action="{{ url('requests') }}" data-abide novalidate>
                @include('partials.error')
                {{ csrf_field() }}
                <div class="small-12 medium-4 cell">
                    <label class="text-right middle{{ $errors->has('title') ? ' is-invalid-label' : '' }}">
                        {{ __('system.title') }}
                    </label>
                </div>
                <div class="small-12 medium-8 cell">
                    <select name="title" id="title" required>
                        @foreach (__('system.titles') as $title)
                            <option value="{{ $title }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('title'))
                        <span class="form-error is-visible">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="small-12 medium-4 cell">
                    <label class="text-right middle{{ $errors->has('first_name') ? ' is-invalid-label' : '' }}">
                        {{ __('system.first_name') }}
                    </label>
                </div>
                <div class="small-12 medium-8 cell">
                    <input type="text" name="first_name" id="first_name" pattern="text" required>
                    @if ($errors->has('first_name'))
                    <span class="form-error">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="small-12 medium-4 cell">
                    <label class="text-right middle{{ $errors->has('last_name') ? ' is-invalid-label' : '' }}">
                        {{ __('system.last_name') }}
                    </label>
                </div>
                <div class="small-12 medium-8 cell">
                    <input type="text" name="last_name" id="last_name" pattern="text" required>
                    @if ($errors->has('last_name'))
                    <span class="form-error">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="small-12 medium-4 cell">
                    <label class="text-right middle{{ $errors->has('email') ? ' is-invalid-label' : '' }}">
                        {{ __('system.email') }}
                    </label>
                </div>
                <div class="small-12 medium-8 cell">
                    <input type="email" name="email" id="email" pattern="email" required>
                    @if ($errors->has('email'))
                    <span class="form-error">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="small-12 medium-4 cell">
                    <label class="text-right middle">
                        {{ __('system.type') }}
                    </label>
                </div>
                <div class="small-12 medium-8 cell">
                    <select name="ticket" id="ticket" required>
                        @foreach (\Jano\Models\Ticket::all() as $ticket)
                            <option value="{{ $ticket->id }}">{{ $ticket->name }} ({{ $ticket->full_name }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="small-12 cell">
                    <button type="submit" class="button">{{ __('system.submit') }}</button>
                    <a class="button hollow" href="{{ url('/') }}">
                        {{ __('system.back') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $('select[name="title"]>option[value="{{ old('title') }}"]').prop('selected', true);
        $('select[name="ticket"]>option[value="{{ old('ticket') }}"]').prop('selected', true);
    </script>
@endpush