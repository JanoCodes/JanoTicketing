@extends('layouts.backend')

@section('title', __('system.create_payment'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form id="form" role="form" method="POST" action="{{ route('backend.payments.create') }}">
    <div class="grid-x grid-padding-x">
        @include('partials.error')
        {{ csrf_field() }}
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('account') ? ' is-invalid-label' : '' }}">
                {{ __('system.account') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
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
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('amount') ? ' is-invalid-label' : '' }}">
                {{ __('system.amount_paid') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <div class="input-group">
                <span class="input-group-label">{{ Setting::get('payment.currency') }}</span>
                <input name="amount" id="amount" class="input-group-field" type="number" pattern="integer"
                    required>
            </div>
            @if ($errors->has('amount'))
                <span class="form-error">
                    <strong>{{ $errors->first('amount') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('method') ? ' is-invalid-label' : '' }}">
                {{ __('system.method') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <select id="method" name="method" required>
                @foreach (__('system.payment_methods') as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($errors->has('method'))
                <span class="form-error">
                    <strong>{{ $errors->first('method') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('reference') ? ' is-invalid-label' : '' }}">{{ __('system.reference') }}</label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="text" name="reference" id="reference" required>
            @if ($errors->has('reference'))
                <span class="form-error">
                    <strong>{{ $errors->first('reference') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('internal_reference') ? ' is-invalid-label' : '' }}">
                {{ __('system.internal_reference') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="text" name="internal_reference" id="internal_reference">
            @if ($errors->has('internal_reference'))
                <span class="form-error">
                    <strong>{{ $errors->first('internal_reference') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-offset-3 small-9 large-8 cell">
            <a class="button warning" href="{{ request('redirect') ? urldecode(request('redirect')) :
                route('backend.payments.index') }}">{{ __('system.back') }}</a>
            <button type="submit" class="button">{{ __('system.submit') }}</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    (function($){
        $.getQuery = function( query ) {
            query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
            var expr = "[\\?&]"+query+"=([^&#]*)";
            var regex = new RegExp( expr );
            var results = regex.exec( window.location.href );
            if( results !== null ) {
                return results[1];
                return decodeURIComponent(results[1].replace(/\+/g, " "));
            } else {
                return false;
            }
        };
    })(jQuery);

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
</script>
@endpush