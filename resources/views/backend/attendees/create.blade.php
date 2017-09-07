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
            <v-select :value.sync="user" :debounce="500" :on-search="getOptions" :options="options"
                 placeholder="{{ __('system.search') }}">
            </v-select>
        </div>
        <div class="small-12 large-offset-1 large-10 cell">
            <ul class="tabs" data-tabs id="attendee-tabs">
                <template v-for="(attendee, index) in attendees">
                    <li class="tabs-title" :class="{ 'is-active': index === 0 }">
                        <a :data-tabs-target="'panel' + index" :href="'#panel' + index">
                            {{ __('system.attendee') }} #@{{ index + 1 }}
                        </a>
                    </li>
                </template>
            </ul>
            <div class="tabs-content" data-tabs-content="attendee-tabs">
                <template v-for="(attendee, index) in attendees">
                    <div class="tabs-panel" :class="{ 'is-active': index === 0 }" :id="'panel' + index">
                        <div class="grid-x grid-padding-x">
                            <div v-if="index !== 0" class="small-12 cell text-right">
                                <button type="button" class="button small alert"
                                    @click="deleteAttendee(index)">
                                    {{ __('system.delete') }}
                                </button>
                            </div>
                            <div class="small-12 medium-4 cell">
                                <label class="text-right middle">{{ __('system.title') }}</label>
                            </div>
                            <div class="small-12 medium-8 cell">
                                <select :name="'attendees.' + index + '.title'" id="title" v-model="attendee.title" required>
                                    @foreach (__('system.titles') as $title)
                                        <option value="{{ $title }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="small-12 medium-4 cell">
                                <label class="text-right middle">{{ __('system.first_name') }}</label>
                            </div>
                            <div class="small-12 medium-8 cell">
                                <input type="text" :name="'attendees.' + index + '.first_name'" id="first_name"
                                       v-model="attendee.first_name" pattern="text" required>
                            </div>
                            <div class="small-12 medium-4 cell">
                                <label class="text-right middle">{{ __('system.last_name') }}</label>
                            </div>
                            <div class="small-12 medium-8 cell">
                                <input type="text" :name="'attendees.' + index + '.last_name'" id="last_name"
                                       v-model="attendee.last_name" pattern="text" required>
                            </div>
                            <div class="small-12 medium-4 cell">
                                <label class="text-right middle">{{ __('system.email') }}</label>
                            </div>
                            <div class="small-12 medium-8 cell">
                                <input type="email" :name="'attendees.' + index + '.email'" id="email" v-model="attendee.email"
                                       pattern="email" required>
                            </div>
                            <div class="small-12 medium-4 cell">
                                <label class="text-right middle">{{ __('system.type') }}</label>
                            </div>
                            <div class="small-12 medium-8 cell">
                                <select :name="'attendees.' + index + '.ticket'" id="ticket"
                                    v-model="attendee.ticket" required>
                                    @foreach (\Jano\Models\Ticket::all() as $ticket)
                                        <option value="{{ $ticket->id }}">
                                            {{ $ticket->name }} ({{ $ticket->full_price }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <div class="small-12 large-10 text-right cell">
            <div class="clearfix">&nbsp;</div>
            <button type="button" class="button secondary hollow" @click="addAttendee">
                {{ __('system.add_attendee') }}
            </button>
            <button type="button" class="button" @click="submit">{{ __('system.submit') }}</button>
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
            options: [],
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