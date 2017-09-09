@extends('layouts.app')

@section('title', __('system.transfer_create'))

@section('content')
<div class="grid-x grid-padding-x">
    <div class="small-12 cell">
        <h3>{{ __('system.transfer_create') }}</h3>
        <form role="form" method="POST" action="{{ url('transfer') }}" data-abide novalidate>
            <div class="grid-x">
                @include('partials.error')
                {{ csrf_field() }}
                <div class="small-4 cell">
                    <label class="text-right middle">
                        {{ __('system.attendee') }}
                    </label>
                </div>
                <div class="small-8 cell">
                    <span class="field-content">
                        {{ $attendee->title }} {{ $attendee->first_name }} {{ $attendee->last_name }}
                    </span>
                </div>
                <div class="small-4 cell">
                    <label class="text-right middle">
                        {{ __('system.type') }}
                    </label>
                </div>
                <div class="small-8 cell">
                    <span class="field-content">{{ $attendee->ticket->name }}</span>
                </div>
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
                <div class="small-12 cell">
                    <button type="submit" class="button">{{ __('system.submit') }}</button>
                    <a class="button hollow" href="{{ route('accounts.view') }}">
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
        $('select[name="title"]>option[value="{{ old('title') }}"]').prop('selected', true);
    </script>
@endpush