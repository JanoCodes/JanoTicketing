@extends('layouts.backend')

@section('title', __('system.create_order'))

@section('content')
<div class="clearfix">&nbsp;</div>
<form role="form" id="form" method="POST" action="{{ route('backend.attendees.store') }}">
    @include('partials.error')
    {{ csrf_field() }}
    <div class="row">
        <label class="col-sm-3 offset-lg-1 col-lg-3 col-form-label">
            {{ __('system.user') }}
        </label>
        <div class="col-sm-9 col-lg-7">
            <v-select :value.sync="user" :debounce="500" :on-search="getOptions" :options="options"
                 placeholder="{{ __('system.search') }}">
            </v-select>
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="row">
        <div class="col-sm-12 offset-lg-1 col-lg-10">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <template v-for="(attendee, index) in attendees">
                        <a class="nav-item nav-link" :class="{ 'active': index === 0 }"
                           data-toggle="tab" :href="'#panel' + index">
                            {{ __('system.attendee') }} #@{{ index + 1 }}
                        </a>
                    </template>
                </div>
            </nav>
            <div class="tab-content">
                <template v-for="(attendee, index) in attendees">
                    <div class="tabs-pane fade" :class="{ 'show active': index === 0 }" :id="'panel' + index">
                        <div class="card attendee-form-container">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div v-if="index !== 0" class="col-sm-12">
                                        <button type="button" class="btn btn-sm btn-danger"
                                                @click="deleteAttendee(index)">
                                            {{ __('system.delete') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label" for="title">
                                        {{ __('system.title') }}
                                    </label>
                                    <div class="col-sm-12 col-md-8">
                                        <select :name="'attendees.' + index + '.title'" id="title"
                                                v-model="attendee.title" class="custom-select" required>
                                            @foreach (__('system.titles') as $title)
                                                <option value="{{ $title }}">{{ $title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label" for="first_name">
                                        {{ __('system.first_name') }}
                                    </label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" :name="'attendees.' + index + '.first_name'"
                                               id="first_name" v-model="attendee.first_name" class="form-control"
                                               pattern="text" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">
                                        {{ __('system.last_name') }}
                                    </label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" :name="'attendees.' + index + '.last_name'"
                                               id="last_name" class="form-control" v-model="attendee.last_name"
                                               pattern="text" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">
                                        {{ __('system.email') }}
                                    </label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="email" :name="'attendees.' + index + '.email'" id="email"
                                               class="form-control" v-model="attendee.email" pattern="email"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-4 col-form-label">
                                        {{ __('system.type') }}
                                    </label>
                                    <div class="col-sm-12 col-md-8">
                                        <select :name="'attendees.' + index + '.ticket'" class="custom-select"
                                                id="ticket" v-model="attendee.ticket" required>
                                            @foreach (\Jano\Models\Ticket::all() as $ticket)
                                                <option value="{{ $ticket->id }}">
                                                    {{ $ticket->name }} ({{ $ticket->full_price }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <div class="col-sm-12 col-lg-10 text-right">
            <div class="clearfix">&nbsp;</div>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary" @click="addAttendee">
                    {{ __('system.add_attendee') }}
                </button>
                <button type="button" class="btn btn-primary" @click="submit">{{ __('system.submit') }}</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    const vm = new Vue({
        el: '#form',
        @if (isset($user))
        data: {
            user: {
                value: {{ $user->id }},
                label: "{{ $user->first_name }} {{ $user->last_name }}"
            },
            options: [],
        @else
        data: {
            user: '',
            options: [],
        @endif
            attendees: [{
                title: '',
                first_name: '',
                last_name: '',
                email: '',
                ticket: ''
            }]
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
            },
            addAttendee: function() {
                const instance = {
                    title: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    ticket: ''
                };

                const tabs = $('.tabs');
                tabs.foundation('destroy');
                tabs.children('li').show();

                this.$data.attendees.push(instance);
                this.$nextTick(function() {
                    tabs.attr('data-tabs', '');
                    tabs.foundation();
                });
            },
            deleteAttendee: function(index) {
                const tabs = $('.tabs');
                tabs.foundation('destroy');
                tabs.children('li').show();

                this.$data.attendees.splice(index, 1);
                this.$nextTick(function() {
                    tabs.attr('data-tabs', '');
                    tabs.foundation();
                });
            },
            submit: function() {
                $('#form').foundation('validateForm');

                const parent = this;

                axios.post('{{ route('backend.attendees.store') }}', {
                    user: this.$data.user,
                    attendees: this.$data.attendees
                }).then(function(response) {
                    location.href = '{{ route('backend.attendees.index') }}';
                }).catch(function(error) {
                    const form = $('#form');

                    if (error.response && error.response.status === '422') {
                        _.forEach(error.response.data.errors, function (messages, key) {
                            let input = $(':input[name=' + key + ']');

                            let formatted = '<ul>';
                            _.forEach(messages, function (message) {
                                formatted += '<li>' + message + '</li>';
                            });
                            formatted += '</ul>';

                            form.foundation('findFormError', input).first().html(formatted);
                            form.foundation('addErrorClasses', input);
                        });
                    }
                });
            }
        },
        mounted: function() {
            $('#form').foundation();
        }
    });
</script>
@endpush