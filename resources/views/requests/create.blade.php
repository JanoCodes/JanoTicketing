@extends('layouts.app')

@section('title', __('system.request_create'))

@section('content')
<div class="grid-x padding-gutters">
    <div class="small-12 medium-10 large-9 cell">
        <h3>{{ __('system.request_create') }}</h3>
        <form role="form" method="POST" action="{{ url('requests') }}" data-abide novalidate>
            <div class="grid-x">
                @include('partials.error')
                {{ csrf_field() }}
                <div class="small-4 cell">
                    <label class="text-right middle{{ $errors->has('title') ? ' is-invalid-label' : '' }}">
                        {{ __('system.title') }}
                    </label>
                </div>
                <div class="small-8 cell">
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
                <div class="small-4 cell">
                    <label class="text-right middle{{ $errors->has('first_name') ? ' is-invalid-label' : '' }}">
                        {{ __('system.first_name') }}
                    </label>
                </div>
                <div class="small-8 cell">
                    <input type="text" name="first_name" id="first_name" pattern="text" required>
                    @if ($errors->has('first_name'))
                    <span class="form-error">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="small-4 cell">
                    <label class="text-right middle{{ $errors->has('last_name') ? ' is-invalid-label' : '' }}">
                        {{ __('system.last_name') }}
                    </label>
                </div>
                <div class="small-8 cell">
                    <input type="text" name="last_name" id="last_name" pattern="text" required>
                    @if ($errors->has('last_name'))
                    <span class="form-error">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="small-4 cell">
                    <label class="text-right middle{{ $errors->has('email') ? ' is-invalid-label' : '' }}">
                        {{ __('system.email') }}
                    </label>
                </div>
                <div class="small-8 cell">
                    <input type="email" name="email" id="email" pattern="email" required>
                    @if ($errors->has('email'))
                    <span class="form-error">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="small-4 cell">
                    <label class="text-right middle">
                        {{ __('system.type') }}
                    </label>
                </div>
                <div class="small-8 cell">
                    @foreach (\Jano\Models\Ticket::all() as $ticket)
                    <select name="ticket[{{ $ticket->id }}]" id="ticket" class="ticket-preference" required>
                        <option value="0" selected></option>
                        @for ($i = 1; $i <= \Jano\Models\Ticket::all()->count(); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    &nbsp;{{ $ticket->name }} <i>({{ $ticket->full_price }})</i>
                    @endforeach
                </div>
                <div class="small-12 medium-8 medium-offset-4 cell">
                    <button type="submit" class="button">{{ __('system.submit') }}</button>
                    <a class="button hollow" href="{{ url('/') }}">
                        {{ __('system.back') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
    <script type="text/javascript">
        @if (old('title'))
        $('select[name="title"]>option[value="{{ old('title') }}"]').prop('selected', true);
        @endif
        @foreach (\Jano\Models\Ticket::all() as $ticket)
        @if (old('ticket.' . $ticket->id))
        $('select[name="ticket"]>option[value="{{ old('ticket.' . $ticket->id) }}"]').prop('selected', true);
        @endif
        @endforeach
    </script>
@endpush