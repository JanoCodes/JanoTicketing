@extends('layouts.backend')

@section('title', __('system.create_staff'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form id="form" role="form" method="POST" action="{{ route('backend.staff.store') }}">
    <div class="grid-x grid-padding-x">
        @include('partials.error')
        {{ csrf_field() }}
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('user') ? ' is-invalid-label' : '' }}">
                {{ __('system.user') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <v-select :debounce="500" :value.sync="user" :on-change="setUser" :on-search="getOptions"
                :options="options" placeholder="{{ __('system.search') }}">
            </v-select>
            <input type="hidden" name="user" id="user">
            @if ($errors->has('user'))
                <span class="form-error">
                    <strong>{{ $errors->first('user') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle{{ $errors->has('access_level') ? ' is-invalid-label' : '' }}">
                {{ __('system.access_level') }}
            </label>
        </div>
        <div class="small-9 large-8 cell">
            <input type="number" name="access_level" id="access_level" pattern="integer" required>
            @if ($errors->has('access_level'))
                <span class="form-error">
                    <strong>{{ $errors->first('access_level') }}</strong>
                </span>
            @endif
        </div>
        <div class="small-offset-3 small-9 large-8 cell">
            <a class="button warning" href="{{ route('backend.staff.index') }}">{{ __('system.back') }}</a>
            <button class="button" type="submit">{{ __('system.submit') }}</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    const vm = new Vue({
        el: '#form',
        data: {
            user: '',
            options: []
        },
        methods: {
            getOptions: function(search, loading) {
                loading(true);

                let parent = this;

                axios.get('{{ route('backend.users.index') }}' + '?q=' + search)
                    .then(function (response) {
                        parent.$data.options = $.map(response.data.data, function(val) {
                            return {
                                label: val.first_name + ' ' + val.last_name,
                                value: val.id
                            };
                        });
                        parent.$nextTick(() => loading(false));

                        loading(false);
                    });
            },
            setUser: function() {
                $('input[name=user]').val(this.$data.user.value);
            }
        }
    });
</script>
@endpush