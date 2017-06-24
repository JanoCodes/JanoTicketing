@extends('layouts.app')

@section('title', __('system.home'))

@section('content')
    <div class="grid-x grid-padding-x">
        <div class="small-12 medium-8 cell callout">
            <form method="POST" target="{{ route('orders.store') }}" id="form" data-abide novalidate>
                @include('partials.error')
                {{ csrf_field() }}
                <component v-bind:is="formView">
                </component>
                <div class="grid-x grid-padding-x">
                    <div class="small-12 cell">
                        <div class="float-right">
                            <button id="back" type="button" class="button" v-on:click="back" disabled>
                                {{ __('system.back') }}
                            </button>
                            <button id="next" type="button" class="button" v-on:click="next">
                                {{ __('system.next') }}
                            </button>
                            <button id="submit" type="button" class="button"
                                    style="display: none;" v-on:click="submit">{{ __('system.submit') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="small-12 medium-4 cell">
            <div class="callout">

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/html" id="users">
    <div class="grid-x grid-padding-x">
        <div class="small-12 medium-4 cell">
            <label class="text-right middle">{{ __('system.title') }}</label>
        </div>
        <div class="small-12 medium-8 cell">
            <select name="title" id="title" v-model="title" required>
                @foreach (__('system.titles') as $title)
                    <option value="{{ $title }}">{{ $title }}</option>
                @endforeach
            </select>
        </div>
        <div class="small-12 medium-4 cell">
            <label class="text-right middle">{{ __('system.first_name') }}</label>
        </div>
        <div class="small-12 medium-8 cell">
            <input type="text" name="first_name" id="first_name" v-model="firstName" pattern="text"
                   required>
            <span class="form-error">
                <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.first_name'))]) }}</strong>
            </span>
        </div>
        <div class="small-12 medium-4 cell">
            <label class="text-right middle">{{ __('system.last_name') }}</label>
        </div>
        <div class="small-12 medium-8 cell">
            <input type="text" name="last_name" id="last_name" v-model="lastName" pattern="text"
                   required>
            <span class="form-error">
                <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.last_name'))]) }}</strong>
            </span>
        </div>
        <div class="small-12 medium-4 cell">
            <label class="text-right middle">{{ __('system.email') }}</label>
        </div>
        <div class="small-12 medium-8 cell">
            <input type="email" name="email" id="email" v-model="email" pattern="email" required>
            <span class="form-error">
                <strong>{{ __('validation.email', ['attribute' => strtolower(__('system.email'))]) }}</strong>
            </span>
        </div>
        <div class="small-12 medium-4 cell">
            <label class="text-right middle">{{ __('system.phone') }}</label>
        </div>
        <div class="small-12 medium-8 cell">
            <input type="text" name="phone" id="phone" v-model="phone" pattern="tel" required>
            <span class="form-error">
                <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.phone'))]) }}</strong>
            </span>
        </div>
    </div>
</script>
<script type="text/html" id="guests">
    <div>
        <ul class="tabs" data-tabs id="attendees-tabs">
            <div v-for="(attendee, index) in attendees">
                <li class="tabs-title">
                    <a :href="'#panel' + attendee.id" aria-selected="true">
                        {{ __('system.attendee') }} #@{{ index + 1 }}
                    </a>
                </li>
            </div>
        </ul>
        <div class="tabs-content" data-tabs-content="attendees-tabs">
            <div v-for="(attendee, index) in attendees">
                <div class="tabs-panel" :class="{ 'is-active': index == 0 }"
                     :id="'panel' + attendee.id">
                    <div class="grid-x grid-padding-x">
                        <div class="small-12 medium-4 cell">
                            <label class="text-right middle">{{ __('system.title') }}</label>
                        </div>
                        <div class="small-12 medium-8 cell">
                            <select name="title" id="title" v-model="attendee.title" required>
                                @foreach (__('system.titles') as $title)
                                    <option value="{{ $title }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="small-12 medium-4 cell">
                            <label class="text-right middle">{{ __('system.first_name') }}</label>
                        </div>
                        <div class="small-12 medium-8 cell">
                            <input type="text" name="first_name" id="first_name" v-model="attendee.firstName"
                                   pattern="text" required>
                            <span class="form-error">
                                <strong>
                                    {{ __('validation.required', ['attribute' => strtolower(__('system.first_name'))]) }}
                                </strong>
                            </span>
                        </div>
                        <div class="small-12 medium-4 cell">
                            <label class="text-right middle">{{ __('system.last_name') }}</label>
                        </div>
                        <div class="small-12 medium-8 cell">
                            <input type="text" name="last_name" id="last_name" v-model="attendee.lastName"
                                   pattern="text" required>
                            <span class="form-error">
                                <strong>
                                    {{ __('validation.required', ['attribute' => strtolower(__('system.last_name'))]) }}
                                </strong>
                            </span>
                        </div>
                        <div class="small-12 medium-4 cell">
                            <label class="text-right middle">{{ __('system.email') }}</label>
                        </div>
                        <div class="small-12 medium-8 cell">
                            <input type="email" name="email" id="email" v-model="attendee.email"
                                   pattern="email" required>
                            <span class="form-error">
                                <strong>
                                    {{ __('validation.email', ['attribute' => strtolower(__('system.email'))]) }}
                                </strong>
                            </span>
                        </div>
                        <div class="small-12 medium-4 cell">
                            <label class="text-right middle">{{ __('system.type') }}</label>
                        </div>
                        <div class="small-12 medium-8 cell">
                            <label class="text-disabled">@{{ attendee.type }}</label>
                        </div>
                        <div class="small-12 medium-offset-4 medium-8 cell">
                            <input name="donation" id="donation" type="checkbox"
                                   v-model="attendee.donation">
                            <label>{{ __('system.donation') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer"></div>
    </div>
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var abide;
        var formData = new Vuex.Store({
            state: {!! json_encode($state) !!},
            mutations: {
                update: function (state, payload) {
                    $.each(payload, function (index, value) {
                        state[index] = value;
                    });
                }
            }
        });

        Vue.component('users', {
            template: '#users',
            data: function () {
                return {
                    title: formData.state.title,
                    firstName: formData.state.firstName,
                    lastName: formData.state.lastName,
                    email: formData.state.email,
                    phone: formData.state.phone
                };
            },
            methods: {
                update: function (event) {
                    formData.commit('update', this.$data);
                }
            }
        });

        Vue.component('guests', {
            template: '#guests',
            data: function () {
                return {
                    title: formData.state.title,
                    firstName: formData.state.firstName,
                    lastName: formData.state.lastName,
                    email: formData.state.email,
                    phone: formData.state.phone,
                    attendees: formData.state.attendees
                };
            }
        });

        var vm = new Vue({
            el: "#form",
            data: {
                formView: "users",
                views: [
                    "users",
                    "guests"
                ],
                title: formData.state.title,
                firstName: formData.state.firstName,
                lastName: formData.state.lastName,
                email: formData.state.email,
                phone: formData.state.phone,
                attendees: formData.state.attendees
            },
            methods: {
                next: function (event) {
                    var error = false;
                    $('#form').on('forminvalid.zf.abide', function(event, form) {
                            error = true;
                        })
                        .foundation('validateForm');
                    if (error === true) {
                        return;
                    }

                    var i = $.inArray(this.formView, this.views);
                    if (i < -1 || i + 1 >= this.views.length) {
                        alert('{{ __('system.form_error') }}');
                        return;
                    }
                    this['$children'][i].update();

                    i++;
                    if (i + 1 === this.views.length) {
                        $('#next').hide();
                        $('#submit').show();
                    }
                    if (i === 1) {
                        $('#back').prop('disabled', false);
                    }
                    this.formView = this.views[i];
                },
                back: function (event) {
                    var i = $.inArray(this.formView, this.views);
                    i--;

                    if (i + 2 === this.views.length) {
                        $('#next').show();
                        $('#submit').hide();
                    }
                    if (i <= 0) {
                        $('#back').prop('disabled', true);
                    }
                    this.formView = this.views[i];
                },
                submit: function (event) {

                }
            },
            mounted: function (event) {
                $('#form').foundation();
            },
            updated: function (event) {
                Foundation.reInit($('#form'));
            }
        });
    });
</script>
@endpush