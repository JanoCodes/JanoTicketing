@extends('layouts.backend')

@section('title', __('system.create_order'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form role="form" id="form" method="POST" action="{{ route('backend.attendees.store') }}" data-abide novalidate>
    <div class="grid-x grid-padding-x">
        @include('partials.error')
        {{ csrf_field() }}
        <div class="small-3 large-offset-1 large-2 cell">
            <label class="text-right middle">{{ __('system.user') }}</label>
        </div>
        <div class="small-9 large-8 cell">
            <v-select :debounce="500" :on-search="getOptions" :options="options" placeholder="{{ __('system.search') }}">
            </v-select>
        </div>
        <div class="small-12 large-offset-1 large-10 cell">

        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    const vm = new Vue({
        el: '#form',
        data: {
            options: []
        },
        methods: {
            getOptions: function(search, loading) {
                loading(true);

                let parent = this;

                axios.get('{{ route('backend.users.index') }}' + '?q=' + search)
                    .then(function(response) {
                        parent.$data.options = $.map(response.data.data, function(val) {
                            return {
                                label: val.first_name + ' ' + val.last_name,
                                value: val.id
                            };
                        });
                        parent.$nextTick(() => loading(false));
                    });
            }
        }
    });
</script>
@endpush