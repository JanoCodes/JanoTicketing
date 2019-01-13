@extends('layouts.backend')

@section('title', __('system.create_staff'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form id="form" role="form" method="POST" action="{{ route('backend.staffs.store') }}">
    @include('partials.error')
    {{ csrf_field() }}
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label{{ $errors->has('user')
                ? ' is-invalid-label' : '' }}">
            {{ __('system.user') }}
        </label>
        <div class="col-sm-9 col-lg-8">
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
    </div>
    <div class="row form-group">
        <label class="col-sm-3 offset-lg-1 col-lg-2 col-form-label{{ $errors->has('access_level')
                ? ' is-invalid-label' : '' }}">
            {{ __('system.access_level') }}
        </label>
        <div class="col-sm-9 col-lg-8">
            <input type="number" name="access_level" id="access_level" class="form-control" required>
            @if ($errors->has('access_level'))
                <span class="form-error">
                    <strong>{{ $errors->first('access_level') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="row form-group">
        <div class="offset-sm-3 col-sm-9 col-lg-8 cell">
            <div class="btn-group" role="group">
                <a class="btn btn-warning" href="{{ route('backend.staffs.index') }}">
                    {{ __('system.back') }}
                </a>
                <button class="btn btn-primary" type="submit">{{ __('system.submit') }}</button>
            </div>
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
