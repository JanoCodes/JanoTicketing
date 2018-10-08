@extends('layouts.app')

@section('title', __('system.create_order'))

@section('content')
    <div class="grid-x grid-padding-x order-form-container" id="order-form">
        <div class="small-12 medium-8 cell callout">
            <div class="grid-x grid-padding-x">
                <div class="small-12 cell form-progress">
                    <div class="progress" role="progressbar" tabindex="0">
                        <div class="progress-meter" :style="'width: ' + progress + '%;'"></div>
                    </div>
                    <div class="step" :class="{ 'is-active': (step == 1), 'was-active': (step > 1) }">
                        <h1>1</h1>
                        <span>{{ __('system.your_details') }}</span>
                    </div>
                    <div class="step" :class="{ 'is-active': (step == 2), 'was-active': (step > 2) }">
                        <h1>2</h1>
                        <span>{{ __('system.attendees') }}</span>
                    </div>
                    <div class="step" :class="{ 'is-active': (step == 3), 'was-active': (step > 3) }">
                        <h1>3</h1>
                        <span>{{ __('system.order_summary') }}</span>
                    </div>
                </div>
            </div>
            @include('partials.error')
            <keep-alive>
                <component :is="formView" ref="form" :total-price="totalPrice" :errors="errors"
                    :commited="commited">
                </component>
            </keep-alive>
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
                                style="display: none;" :disabled="agreement ? false : true"
                                v-on:click="submit">{{ __('system.submit') }}</button>
                        <a id="exit" href="{{ route('accounts.view') }}" class="button">{{ __('system.exit') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-12 medium-4 cell sidebar">
            <div class="callout">
                <h4>{{ __('system.order_summary') }}</h4>
                <table>
                    <tbody>
                        <tr v-for="attendee in attendees">
                            <td>
                                <strong>@{{ attendee.ticket.name }}</strong>
                                <template v-if="attendee.title !== '' && attendee.first_name !== ''
                                    && attendee.last_name !== ''">
                                    <br />@{{ attendee.title }} @{{ attendee.first_name }} @{{ attendee.last_name }}
                                </template>
                            </td>
                            <td>
                                @{{ attendee.full_user_ticket_price }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="total-price">
                        <tr>
                            <td></td>
                            <td>@{{ totalPrice }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="callout success" id="countdown">
                <strong>{{ __('system.tickets_reserved_title') }}</strong><br />
                <countdown @countdownprogress="reservationWillExpire" @countdownend="reservationExpires" :time="time"
                    ref="countdown">
                    <template scope="props">{{ __('system.tickets_reserved_message') }}</template>
                </countdown>
            </div>
        </div>
    </div>
    <div class="reveal" id="expiringModal" data-reveal>
        <h2>{{ __('system.reservation_expiring_title') }}</h2>
        <p>{{ __('system.reservation_expiring_message') }}</p>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="reveal order-processing" id="processingModal" data-reveal data-close-on-click="false"
         data-close-on-esc="false">
        <h2>{{ __('system.processing_order_title') }}</h2>
        <p>{{ __('system.processing_order_message') }}</p>
        <i class="fa fa-3x fa-spinner fa-spin"></i>
    </div>
@endsection

@push('scripts')
@foreach (['user', 'guests', 'confirmation', 'success', 'exception'] as $view)
<script type="text/html" id="{!! $view !!}">
    @include('attendees.partials.' . $view)
</script>
@endforeach
<script type="text/javascript">
    $(document).ready(function() {
        let tickets = {!! json_encode($tickets) !!};

        let formData = new Vuex.Store({
            state: {!! json_encode($state) !!},
            mutations: {
                update: function(state, payload) {
                    $.each(payload, function(index, value) {
                        state[index] = value;
                    });
                }
            }
        });

        function processErrorBag(errorBag) {
            _.forEach(errorBag, function(messages, key) {
                let input = $(':input[name=' + key + ']');

                let formatted = '<ul>';
                _.forEach(messages, function(message) {
                    formatted += '<li>' + message + '</li>';
                });
                formatted += '</ul>';

                form.foundation('findFormError', input).first().html(formatted);
                form.foundation('addErrorClasses', input);
            });
        }

        Vue.component('user', {
            template: '#user',
            props: ['errors'],
            data: function() {
                return {
                    title: formData.state.title,
                    first_name: formData.state.first_name,
                    last_name: formData.state.last_name,
                    email: formData.state.email,
                    phone: formData.state.phone
                };
            },
            methods: {
                update: function(event) {
                    formData.commit('update', this.$data);
                },
                load: _.once(function() {
                    $('#form').foundation();

                    if ($(this.errors.user).length > 0) {
                        processErrorBag(this.errors.user);
                    }
                })
            },
            activated: function(event) {
                this.load();
            }
        });

        Vue.component('guests', {
            template: '#guests',
            props: ['errors'],
            data: function() {
                return {
                    hasAttendees: formData.state.has_attendees,
                    attendees: formData.state.attendees
                };
            },
            methods: {
                update: function (event) {
                    formData.commit('update', this.$data);
                },
                primaryTicketHolderOnChange: function (event) {
                    let input = $(event.currentTarget).closest('input[id=primary_ticket_holder]');
                    let id = $(input).attr('name').match(/attendees\.([0-9]+)\.primary_ticket_holder/)[1];

                    if ($(input).prop('checked')) {
                        let newAttendees = this.attendees;

                        newAttendees[id].title = formData.state.title;
                        newAttendees[id].first_name = formData.state.first_name;
                        newAttendees[id].last_name = formData.state.last_name;
                        newAttendees[id].email = formData.state.email;
                        this.attendees = newAttendees;

                        $(':input[name=\'attendees.'+id+'.title\']').prop('disabled', true);
                        $(':input[name=\'attendees.'+id+'.first_name\']').prop('disabled', true);
                        $(':input[name=\'attendees.'+id+'.last_name\']').prop('disabled', true);
                        $(':input[name=\'attendees.'+id+'.email\']').prop('disabled', true);

                        $(':input[id=primary_ticket_holder]').not(input).each(function(index, element) {
                            $(element).prop('disabled', true);
                        });

                        this.$nextTick();
                    } else {
                        let newAttendees = this.attendees;

                        newAttendees[id].title = '';
                        newAttendees[id].first_name = '';
                        newAttendees[id].last_name = '';
                        newAttendees[id].email = '';
                        this.attendees = newAttendees;

                        $(':input[name=\'attendees.'+id+'.title\']').prop('disabled', false);
                        $(':input[name=\'attendees.'+id+'.first_name\']').prop('disabled', false);
                        $(':input[name=\'attendees.'+id+'.last_name\']').prop('disabled', false);
                        $(':input[name=\'attendees.'+id+'.email\']').prop('disabled', false);

                        $('input[id=primary_ticket_holder]').not(input).each(function(index, element) {
                            $(element).prop('disabled', false);
                        });

                        this.$nextTick();
                    }
                },
                load: _.once(function() {
                    if (this.hasAttendees) {
                        $('input[id=primary_ticket_holder]').each(function(index, element) {
                            $(element).prop('checked', false);
                            $(element).prop('disabled', true);
                        });
                    }

                    $('#form').foundation();

                    $('#attendees-tabs').on('change.zf.tabs', _.debounce(function () {
                        const count = $(this.attendees).length;
                        let oldAttendees = formData.state.attendees;

                        for (let i = 0; i < count; i++) {
                            if (this.attendees[i].title && this.attendees[i].first_name && this.attendees[i].last_name
                                && !$('#panellink' + i).hasClass('is-active')) {
                                oldAttendees[i].title = this.attendees[i].title;
                                oldAttendees[i].first_name = this.attendees[i].first_name;
                                oldAttendees[i].last_name = this.attendees[i].last_name;
                                oldAttendees[i].email = this.attendees[i].email;
                            }
                        }

                        vm.attendees = oldAttendees;
                        vm.$nextTick(function() {
                            formData.commit('update', {'attendees': oldAttendees});
                        });
                    }, 1000));
                })
            },
            activated: function (event) {
                this.load();
            }
        });

        Vue.component('confirmation', {
            template: '#confirmation',
            data: function() {
                return {
                    title: formData.state.title,
                    first_name: formData.state.first_name,
                    last_name: formData.state.last_name,
                    email: formData.state.email,
                    phone: formData.state.phone,
                    attendees: formData.state.attendees,
                    agreement: formData.state.agreement,
                };
            },
            props: ['totalPrice'],
            methods: {
                agreementUpdate: function() {
                    let value = $('#agreement').prop('checked');

                    formData.commit('update', {'agreement': value});
                    vm.agreement = value;
                    vm.$nextTick();
                },
                update: function(event) {
                    formData.commit('update', this.$data);
                },
                load: _.once(function() {
                    $('#form').foundation();
                })
            },
            activated: function(){
                this.load();
            }
        });

        Vue.component('success', {
            template: '#success',
            data: function() {
                return {
                    attendees: formData.state.attendees
                };
            },
            props: ['totalPrice'],
            methods: {
                load: _.once(function() {
                    $('#countdown').hide();
                })
            },
            activated: function() {
                this.load();
            }
        });

        Vue.component('exception', {
            template: '#exception'
        });

        const reservationExpiring = _.once(function() {
            console.log('Reservation will expire: opening pop-up.');
            $('#expiringModal').foundation('open');

            const flash = setInterval(function(){
                if (!document.hasFocus()) {
                    (document.title === "{{ __('system.reservation_expiring_popup') }}") ?
                        (document.title = "{{ __('system.create_order') }} - {{ Setting::get('system.title') }}") :
                        (document.title = "{{ __('system.reservation_expiring_popup') }}");
                } else {
                    document.title = "{{ __('system.create_order') }} - {{ Setting::get('system.title') }}";
                    clearInterval(flash);
                }
            }, 1000);
        });

        const vm = new Vue({
            el: '#order-form',
            data: {
                formView: 'user',
                step: 1,
                views: [
                    'user',
                    'guests',
                    'confirmation'
                ],
                time: {{ ($time - time()) * 1000 }},
                title: formData.state.title,
                first_name: formData.state.first_name,
                last_name: formData.state.last_name,
                email: formData.state.email,
                phone: formData.state.phone,
                attendees: formData.state.attendees,
                agreement: formData.state.agreement,
                totalPrice: '',
                commited: null,
                errors: {
                    'user': [],
                    'guests': []
                }
            },
            computed: {
                progress: function() {
                    return (this.$data.step - 1)/(this.$data.views.length - 1) * 100;
                }
            },
            methods: {
                next: function (event) {
                    let error = false;

                    $('#form').on('forminvalid.zf.abide', function(event, form) {
                            error = true;
                        })
                        .foundation('validateForm');

                    if (error === true) {
                        return;
                    }

                    let i = $.inArray(this.$data.formView, this.$data.views);
                    if (i < -1 || i + 1 >= this.$data.views.length) {
                        alert('{{ __('system.form_error') }}');
                        return;
                    }
                    this.$refs.form.update();
                    this.$nextTick();

                    i++;
                    if (i + 1 === this.$data.views.length) {
                        $('#next').hide();
                        $('#submit').show();
                    }
                    if (i === 1) {
                        $('#back').prop('disabled', false);
                    }

                    this.$data.formView = this.$data.views[i];
                    this.$data.step++;
                },
                back: function(event) {
                    let i = $.inArray(this.$data.formView, this.$data.views);
                    i--;

                    if (i + 2 === this.$data.views.length) {
                        $('#next').show();
                        $('#submit').hide();
                    }
                    if (i <= 0) {
                        $('#back').prop('disabled', true);
                    }

                    this.$data.formView = this.$data.views[i];
                    this.$data.step--;
                },
                calculatePrice: function() {
                    const parent = this;

                    _.throttle(
                        function () {
                            let totalPrice = 0;

                            formData.state.attendees.forEach(function (attendee) {
                                totalPrice += attendee.user_ticket_price;
                            });

                            parent.$data.totalPrice = "{{ Setting::get('payment.currency') }}" +
                                totalPrice;
                            parent.$nextTick();
                        },
                        5000
                    )
                },
                submit: function(event) {
                    event.preventDefault();

                    if (formData.state.agreement !== true) {
                        $('div[data-abide-error]').show();
                        $('input#agreement').closest('form-error').addClass('is-visible');
                        return;
                    }

                    const parent = this;

                    $('#processingModal').foundation('open');

                    axios.post('{{ route('attendees.store') }}', formData.state)
                        .then(function(response) {
                            $('#back').hide();
                            $('#next').hide();
                            $('#submit').hide();
                            $('#exit').show();

                            $('#processingModal').foundation('close');

                            parent.$data.formView = 'success';
                        })
                        .catch(function(error) {
                            if (error.response && error.response.status === '422') {
                                const partition = _.partition(error.response.data.errors, function(o){
                                    return Object.keys(o)[0].includes('attendees')
                                });

                                parent.$data.errors.user = partition[1];
                                parent.$data.errors.guests = partition[0];

                                $('#processingModal').foundation('close');

                                if (partition[1].length > 0) {
                                    parent.$data.formView = 'user';
                                    $('#back').prop('disabled', true);
                                    $('#next').show();
                                    $('#submit').hide();
                                }
                                else {
                                    parent.$data.formView = 'guests';
                                    $('#back').prop('disabled', false);
                                    $('#next').show();
                                    $('#submit').hide();
                                }
                            }
                            else {
                                $('#processingModal').foundation('close');

                                $('#back').hide();
                                $('#next').hide();
                                $('#submit').hide();
                                console.log(error.response.data);
                                parent.$data.formView = 'exception';
                            }
                        });
                },
                reservationWillExpire: function(data) {
                    if (data.totalSeconds < 180) {
                        reservationExpiring();
                    }
                },
                reservationExpires: function() {
                    window.location.reload(true);
                }
            },
            mounted: _.once(function() {
                formData.commit('update');

                let totalPrice = 0;
                formData.state.attendees.forEach(function (attendee) {
                    totalPrice += attendee.user_ticket_price;
                });
                this.$data.totalPrice = "{{ Setting::get('payment.currency') }}" + totalPrice;

                $('#exit').hide();

                this.$nextTick();
            })
        });
    });
</script>
@endpush