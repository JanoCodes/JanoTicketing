@extends('layouts.app')

@section('title', __('system.request_edit'))

@section('content')
<div class="grid-x padding-gutters">
    <div class="small-12 medium-10 large-9 cell">
        <h3>{{ __('system.request_edit') }}</h3>
        <form role="form" method="POST" action="{{ url('requests') }}" data-abide novalidate>
            <div class="grid-x">
                @include('partials.error')
                {{ method_field('PATCH') }}
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
                    <input type="text" name="first_name" id="first_name" pattern="text"
                           value="{{ old('first_name') ?? $ticket_request->first_name }}" required>
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
                    <input type="text" name="last_name" id="last_name" pattern="text"
                           value="{{ old('last_name') ?? $ticket_request->last_name }}" required>
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
                    <input type="email" name="email" id="email" pattern="email"
                           value="{{ old('email') ?? $ticket_request->email }}" required>
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
                <div class="small-12 cell">
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
        $('select[name="title"]>option[value="{{ old('title') ?? $ticket_request->title }}"]').prop('selected', true);
        @foreach (\Jano\Models\Ticket::all() as $ticket)
        $('select[name="ticket"]>option[value="{{ old('ticket.' . $ticket->id) ??
            $ticket_request->ticket_preference[$ticket->id] }}"]').prop('selected', true);
        @endforeach
    </script>
@endpush