@extends('layouts.app')

@section('title', __('system.create_order'))

@section('content')
    <div class="grid-x grid-padding-x order-form-container">
        <div class="small-12 medium-8 cell callout">
            <form id="form" data-abide novalidate>
                @include('partials.error')
                <keep-alive>
                    <component v-bind:is="formView">
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
            </form>
        </div>
        <div class="small-12 medium-4 cell sidebar">
            <div class="callout">
                <h4>{{ __('system.order_summary') }}</h4>
                <table>
                    <tr v-for="attendee in attendees">
                        <td>
                            <strong>@{{ attendee.ticket.name }}</strong>
                            <template v-if="attendee.fullName"><br />@{{ attendee.full_name }}</template>
                        </td>
                        <td>
                            @{{ attendee.ticket.price }}
                        </td>
                    </tr>
                    <tfoot>
                        <tr class="total-price">
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
        var form = $('#form');
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
            prop: ['errors'],
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
                }
            },
            mounted: function(event) {
                if (this.errors.user.length > 0) {
                    processErrorBag(this.errors.user);
                }
            }
        });

        Vue.component('guests', {
            template: '#guests',
            prop: ['errors'],
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

                        $('select[name=\'attendees.'+id+'.title\']').prop('disabled', true);
                        $('input[name=\'attendees.'+id+'.first_name\']').prop('readonly', true);
                        $('input[name=\'attendees.'+id+'.last_name\']').prop('readonly', true);
                        $('input[name=\'attendees.'+id+'.email\']').prop('readonly', true);

                        this.$nextTick();

                        $('input[id=primary_ticket_holder]').not(input).each(function(index, element) {
                            $(element).prop('readonly', true);
                        });
                    } else if (!this.attendees[id].primary_ticket_holder) {
                        var newAttendees = this.attendees;

                        newAttendees[id]['title'] = '';
                        newAttendees[id]['first_name'] = '';
                        newAttendees[id]['last_name'] = '';
                        newAttendees[id]['email'] = '';
                        this.attendees = newAttendees;

                        $('select[name=\'attendees.'+id+'.title\']').prop('disabled', false);
                        $('input[name=\'attendees.'+id+'.first_name\']').prop('readonly', false);
                        $('input[name=\'attendees.'+id+'.last_name\']').prop('readonly', false);
                        $('input[name=\'attendees.'+id+'.email\']').prop('readonly', false);

                        this.$nextTick();

                        $('input[id=primary_ticket_holder]').not(input).each(function(index, element) {
                            $(element).prop('readonly', false);
                        });
                    } else {
                        throw new Error('Value of the field `primary ticket holder` is invalid.');
                    }
                }
            },
            mounted: function (event) {
                if (this.errors.guests.length > 0) {
                    processErrorBag(this.errors.guests);
                }

                $('#attendees-tabs').on('change.zf.tabs', _.debounce(function () {
                    var count = this.attendees.length;
                    var oldAttendees = formData.attendees;

                    for (var i = 1; i < count; i++) {
                        if (this.attendees[i].title && this.attendees[i].first_name && this.attendees[i].last_name
                            && !$('#panellink' + i).hasClass('is-active')) {
                            oldAttendees[i].full_name = this.attendees[i].title + ' ' + this.attendees[i].first_name
                                + ' ' + this.attendees[i].last_name;
                            oldAttendees[i].title = this.attendees[i].title;
                            oldAttendees[i].first_name = this.attendees[i].first_name;
                            oldAttendees[i].last_name = this.attendees[i].last_name;
                            oldAttendees[i].email = this.attendees[i].email;
                            oldAttendees[i].charityDonation = this.attendees[i].charityDonation;
                        }
                    }
                    formData.commit('update', {'attendees': oldAttendees});
                }, 1000));
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
            methods: {
                agreementUpdate: function() {
                    formData.commit('update', {'agreement': this.agreement});
                },
                update: function(event) {
                    formData.commit('update', this.$data);
                }
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
            el: '.order-form-container',
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
                getTotalTicketPrice: _.debounce(
                    function () {
                        var totalPrice = 0;

                        this.attendees.forEach(function (attendee) {
                            totalPrice += attendee.ticket.price;
                        });

                        return "{{ Setting::get('payment.currency') }}" + totalPrice;
                    },
                    1000
                )
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
            },
            mounted: function(event) {
                $('#form').foundation();
            },
            updated: function(event) {
                Foundation.reInit($('#form'));
            }
        });
    });
</script>
@endpush