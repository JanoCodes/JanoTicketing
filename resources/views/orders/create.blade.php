@extends('layouts.app')

@section('title', __('system.create_order'))

@section('content')
    <div class="grid-x grid-padding-x order-form-container" id="order-form">
        <div class="small-12 medium-8 cell callout">
                @include('partials.error')
                <keep-alive>
                    <component v-bind:is="formView" :errors="errors">
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
                                @{{ getFullPrice(attendee.ticket.price) }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="total-price">
                        <tr>
                            <td></td>
                            <td>@{{ getTotalPrice }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="reveal order-processing" id="processingModal" data-reveal data-close-on-click="false"
         data-close-on-esc="false">
        <h2>{{ __('system.processing_order_title') }}</h2>
        <p>{{ __('system.processing_order_message') }}</p>
        <i class="fa fa-3x fa-spinner fa-spin"></i>
    </div>
@endsection

@push('scripts')
@foreach (['user', 'guests', 'confirmation', 'exception'] as $view)
<script type="text/html" id="{!! $view !!}">
    @include('orders.partials.' . $view)
</script>
@endforeach
<script type="text/javascript">
    $(document).ready(function() {
        var tickets = {!! json_encode($tickets) !!};

        var formData = new Vuex.Store({
            state: {!! json_encode($state) !!},
            mutations: {
                update: function(state, payload) {
                    $.each(payload, function(index, value) {
                        state[index] = value;
                    });
                }
            }
        });

        function getFullPrice(price) {
            return "{{ Setting::get('payment.currency') }}" + price;
        }

        function processErrorBag(errorBag) {
            _.forEach(errorBag, function(messages, key) {
                var input = $(':input[name=' + key + ']');

                var formatted = '<ul>';
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
                    attendees: formData.state.attendees
                };
            },
            methods: {
                update: function (event) {
                    formData.commit('update', this.$data);
                },
                primaryTicketHolderOnChange: function (event) {
                    var input = $(event.currentTarget).closest('input[id=primary_ticket_holder]');
                    var id = $(input).attr('name').match(/attendees\.([0-9]+)\.primary_ticket_holder/)[1];

                    if (this.attendees[id].primary_ticket_holder) {
                        var newAttendees = this.attendees;

                        newAttendees[id]['title'] = formData.state.title;
                        newAttendees[id]['first_name'] = formData.state.first_name;
                        newAttendees[id]['last_name'] = formData.state.last_name;
                        newAttendees[id]['email'] = formData.state.email;
                        this.attendees = newAttendees;

                        $(':input[name=\'attendees.'+id+'.title\']').prop('disabled', true);
                        $(':input[name=\'attendees.'+id+'.first_name\']').prop('disabled', true);
                        $(':input[name=\'attendees.'+id+'.last_name\']').prop('disabled', true);
                        $(':input[name=\'attendees.'+id+'.email\']').prop('disabled', true);

                        this.$nextTick();

                        $(':input[id=primary_ticket_holder]').not(input).each(function(index, element) {
                            $(element).prop('disabled', true);
                        });
                    } else if (!this.attendees[id].primary_ticket_holder) {
                        var newAttendees = this.attendees;

                        newAttendees[id]['title'] = '';
                        newAttendees[id]['first_name'] = '';
                        newAttendees[id]['last_name'] = '';
                        newAttendees[id]['email'] = '';
                        this.attendees = newAttendees;

                        $(':input[name=\'attendees.'+id+'.title\']').prop('disabled', false);
                        $(':input[name=\'attendees.'+id+'.first_name\']').prop('disabled', false);
                        $(':input[name=\'attendees.'+id+'.last_name\']').prop('disabled', false);
                        $(':input[name=\'attendees.'+id+'.email\']').prop('disabled', false);

                        this.$nextTick();

                        $('input[id=primary_ticket_holder]').not(input).each(function(index, element) {
                            $(element).prop('readonly', false);
                        });
                    } else {
                        throw new Error('Value of the field `primary ticket holder` is invalid.');
                    }
                },
                load: _.once(function() {
                    $('#form').foundation();

                    $('#attendees-tabs').on('change.zf.tabs', _.debounce(function () {
                        var count = $(this.attendees).length;
                        var oldAttendees = formData.state.attendees;

                        for (var i = 0; i < count; i++) {
                            if (this.attendees[i].title && component.attendees[i].first_name && this.attendees[i].last_name
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
                    agreement: formData.state.agreement
                };
            },
            computed: {
                getTotalPrice: function() {
                    return vm.calculatePrice();
                }
            },
            methods: {
                agreementUpdate: function() {
                    formData.commit('update', {'agreement': this.agreement});
                    vm.agreement = this.agreement;
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
            prop: ['commited']
        });

        Vue.component('exception', {
            template: '#exception'
        });

        var vm = new Vue({
            el: '#order-form',
            data: {
                formView: 'user',
                views: [
                    'user',
                    'guests',
                    'confirmation'
                ],
                title: formData.state.title,
                first_name: formData.state.first_name,
                last_name: formData.state.last_name,
                email: formData.state.email,
                phone: formData.state.phone,
                attendees: formData.state.attendees,
                agreement: formData.state.agreement,
                commited: null,
                errors: {
                    'user': [],
                    'guests': []
                }
            },
            computed: {
                getTotalPrice: function() {
                    return this.calculatePrice();
                }
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
                    this.$nextTick();

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
                back: function(event) {
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
                calculatePrice: _.throttle(
                    function () {
                        var totalPrice = 0;

                        formData.state.attendees.forEach(function (attendee) {
                            totalPrice += attendee.ticket.price;
                        });

                        return "{{ Setting::get('payment.currency') }}" + totalPrice;
                    },
                    5000
                ),
                submit: function(event) {
                    event.preventDefault();

                    if (formData.agreement !== '1') {
                        $('div[data-abide-error]').show();
                        $('input#agreement').closest('form-error').addClass('is-visible');
                        return;
                    }

                    axios.post('{{ route('orders.store') }}', formData)
                        .then(function(response) {
                            $('#back').hide();
                            $('#next').hide();
                            $('#submit').hide();
                            this.commited = response.data;
                            this.formView = 'success';
                        })
                        .catch(function(error) {
                            if (error.response && error.response.status === '422') {
                                var partition = _.partition(error.response.data.errors, function(o){
                                    return Object.keys(o)[0].includes('attendees')
                                });

                                this.errors.user = partition[1];
                                this.errors.guests = partition[0];

                                $('#processingModal').foundation('close');

                                if (partition[1].length > 0) {
                                    this.formView = 'user';
                                    $('#back').prop('disabled', true);
                                    $('#next').show();
                                    $('#submit').hide();
                                }
                                else {
                                    this.formView = 'guests';
                                    $('#back').prop('disabled', false);
                                    $('#next').show();
                                    $('#submit').hide();
                                }
                            }
                            else {
                                $('#back').hide();
                                $('#next').hide();
                                $('#submit').hide();
                                this.formView('exception');
                            }
                        });
                }
            }
        });
    });
</script>
@endpush