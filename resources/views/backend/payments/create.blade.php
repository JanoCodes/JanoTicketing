@extends('layouts.backend')

@section('title', __('system.create_payment'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form id="form" role="form" method="POST" action="{{ route('backend.payments.store') }}">
    @include('partials.error')
    {{ csrf_field() }}
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label{{ $errors->has('account')
                ? ' is-invalid-label' : '' }}">
            {{ __('system.account') }}
        </label>
        <div class="col-sm-9 col-lg-8">
            <v-select :debounce="500" :value.sync="account" :on-change="setAccount" :on-search="getOptions"
                :options="options" placeholder="{{ __('system.search') }}">
            </v-select>
            <input type="hidden" name="account" id="account">
            @if ($errors->has('account'))
                <span class="form-error">
                    <strong>{{ $errors->first('account') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label{{ $errors->has('amount')
                ? ' is-invalid-label' : '' }}">
            {{ __('system.amount_paid') }}
        </label>
        <div class="col-sm-9 col-md-8">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">{{ Setting::get('payment.currency') }}</span>
                </div>
                <input name="amount" id="amount" class="form-control" type="number" pattern="integer" required>
            </div>
            @if ($errors->has('price'))
                <span class="form-error">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label{{ $errors->has('type')
                ? ' is-invalid-label' : '' }}">
            {{ __('system.method') }}
        </label>
        <div class="col-sm-9 col-lg-8">
            <select id="type" name="type" class="custom-select" required>
                @foreach (__('system.payment_methods') as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($errors->has('type'))
                <span class="form-error">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label{{ $errors->has('reference')
                ? ' is-invalid-label' : '' }}">
            {{ __('system.reference') }}
        </label>
        <div class="col-sm-9 col-lg-8">
            <input type="text" name="reference" id="reference" class="form-control" required>
            @if ($errors->has('reference'))
                <span class="form-error">
                    <strong>{{ $errors->first('reference') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label{{ $errors->has('internal_reference')
                ? ' is-invalid-label' : '' }}">
            {{ __('system.internal_reference') }}
        </label>
        <div class="col-sm-9 col-lg-8">
            <input type="text" name="internal_reference" id="internal_reference" class="form-control">
            @if ($errors->has('internal_reference'))
                <span class="form-error">
                    <strong>{{ $errors->first('internal_reference') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="row form-group">
        <div class="offset-sm-3 col-sm-9 col-lg-8">
            <div class="btn-group">
                <a class="btn btn-warning" href="{{ request('redirect') ? urldecode(request('redirect')) :
                route('backend.payments.index') }}">{{ __('system.back') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('system.submit') }}</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    const vm = new Vue({
        el: '#form',
        @if (isset($account))
        data: {
            account: {
                value: {{ $account->id }},
                label: "{{ $account->user()->first()->first_name }} {{ $account->user()->first()->last_name }}"
            },
            options: []
        },
        @else
        data: {
            account: '',
            options: []
        },
        @endif
        methods: {
            getOptions: function(search, loading) {
                loading(true);

                let parent = this;

                axios.get('{{ route('backend.users.index') }}' + '?q=' + search)
                    .then(function (response) {
                        parent.$data.options = $.map(response.data.data, function(val) {
                            return {
                                label: val.first_name + ' ' + val.last_name,
                                value: val.account.id
                            };
                        });
                        parent.$nextTick(() => loading(false));

                        loading(false);
                    });
            },
            setAccount: function() {
                $('input[name=account]').val(this.$data.account.value);
            }
        }
    });

    (function($){
        $.getQuery = function( query ) {
            query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
            var expr = "[\\?&]"+query+"=([^&#]*)";
            var regex = new RegExp( expr );
            var results = regex.exec( window.location.href );
            if( results !== null ) {
                return decodeURIComponent(results[1].replace(/\+/g, " "));
            } else {
                return false;
            }
        };
    })($);
</script>
@endpush
