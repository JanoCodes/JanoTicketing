@extends('layouts.backend')

@section('title', __('system.user'))

@section('content')
    <div class="grid-x cell" id="user-show-container">
        <div class="grid-x text-wrap">
            <div class="auto cell">
                <h3>{{ $user->title }} {{ $user->first_name }} {{ $user->last_name }}</h3>
                {{ $user->email }}<br />
                {{ $user->group()->first()->name }}<br />
                <strong>{{ __('system.amount_outstanding') }}:</strong> {{ $account->full_amount_outstanding }}
            </div>
            <div class="shrink cell">
                {{ $account->formatted_status }}
            </div>
        </div>
        <div class="grid-x cell text-wrap">
            <a class="button hollow small" href="{{ route('backend.attendees.create') . '?' .
                http_build_query(['user' => $user->id, 'redirect' => url()->current()]) }}">
                {{ __('system.create_order') }}
            </a>
        </div>

        @if ($user->attendees()->count() !== 0)
        <table>
            <thead>
            <tr>
                <th>{{ __('system.attendee') }}</th>
                <th>{{ __('system.email') }}</th>
                <th>{{ __('system.type') }}</th>
                <th></th>
            </tr>
            </thead>
            @foreach ($user->attendees()->get() as $attendee)
                <tr>
                    <td>
                        <strong>{{ $attendee->title }} {{ $attendee->first_name }} {{ $attendee->last_name }}</strong>
                    </td>
                    <td>
                        {{ $attendee->email }}
                    </td>
                    <td>
                        <strong>{{ $attendee->ticket->name }}</strong>
                    </td>
                    <td>
                        <button type="button" class="button tiny warning"
                            @click="editItem('attendee', {{ $attendee->id }})">
                            {{ __('system.edit') }}
                        </button>
                        @if (!$attendee->paid)
                            <button type="button" class="button tiny danger cancel-ticket"
                                @click="deleteItem('attendees', {{ $attendee->id }})">
                                {{ __('system.attendee_cancel') }}
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            <tfoot>
            <tr>
                <td colspan="3"></td>
                <td>
                    <button type="button" class="button tiny hollow" data-open="primary-modal">
                        {{ __('system.update_primary_ticket_holder') }}
                    </button>
                </td>
            </tr>
            </tfoot>
        </table>
        <div class="reveal" id="primary-modal" data-reveal>
            <h3>
                <i class="fa fa-user" aria-hidden="true"></i> {{ __('system.update_primary_ticket_holder') }}
            </h3>
            <form method="POST" action="{{ route('backend.users.update', ['user' => $user]) }}" data-abide
                novalidate>
                @include('partials.error')
                <div class="grid-x grid-padding-x">
                    <div class="small-12 medium-3 cell">
                        <label class="text-right">{{ __('system.primary_ticket_holder') }}</label>
                    </div>
                    <div class="small-12 medium-9 cell">
                        <select name="primary_tickcet_holder" id="primary_ticket_holder" required>
                            @foreach ($user->attendees()->get() as $attendee)
                                <option value="{{ $attendee->id }}"{{ $attendee->primary_ticket_holder ?
                                    ' selected' : '' }}>
                                    {{ $attendee->first_name }} {{ $attendee->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="small-12 medium-offset-3 medium-9 cell">
                        <button type="button" class="button warning" data-close>
                            {{ __('system.back') }}
                        </button>
                        <button type="submit" class="button">{{ __('system.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
            <div class="small reveal" id="cancel-attendees-container" data-reveal>
                <p class="lead text-alert">
                    <strong>
                        {{ __('system.cancel_alert', ['attribute' => strtolower(__('system.attendee'))]) }}
                    </strong><br />
                    <small>{{ __('system.cancel_small') }}</small>
                </p>
                <form role="form" method="POST" action="#">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="alert button">{{ __('system.continue') }}</button>
                    <button type="button" class="secondary button" href="#" data-close>
                        {{ __('system.back') }}
                    </button>
                </form>
            </div>

        <div class="text-wrap">
            <strong>{{ __('system.charges') }}</strong>&nbsp;&nbsp;
            <a class="button hollow small" href="{{ route('backend.payments.create') . '?' .
                http_build_query(['account' => $account->id, 'redirect' => url()->current()]) }}">
                {{ __('system.create_payment') }}
            </a>
        </div>
            <table>
                <thead>
                <tr>
                    <th>{{ __('system.amount_due') }}</th>
                    <th>{{ __('system.description') }}</th>
                    <th>{{ __('system.payment_due') }}</th>
                </tr>
                </thead>
                @foreach ($account->charges()->get() as $charge)
                    <tr>
                        <td>{{ $charge->full_amount }}</td>
                        <td>{{ $charge->description }}</td>
                        <td>{{ $charge->due_at->toDateString() }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        @if ($account->payments()->count() !== 0)
            <strong class="text-alert">{{ __('system.payments') }}</strong>
            <table>
                <thead>
                <tr>
                    <th>{{ __('system.date_credited') }}</th>
                    <th>{{ __('system.amount_paid') }}</th>
                    <th>{{ __('system.method') }}</th>
                    <th>{{ __('system.reference') }}</th>
                </tr>
                </thead>
                @foreach ($account->payments()->get() as $payment)
                    <tr>
                        <td>{{ $payment->made_at->toDateString() }}</td>
                        <td>{{ $payment->full_amount }}</td>
                        <td>{{ __('system.payment_methods.' . $payment->method) }}</td>
                        <td>{{ $payment->reference }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        @if ($user->transferRequests()->count() !== 0)
            <strong>{{ __('system.ticket_transfer_request') }}</strong>
            <table>
                <thead>
                <tr>
                    <th>{{ __('system.original_attendee') }}</th>
                    <th>{{ __('system.new_attendee') }}</th>
                    <th>{{ __('system.status') }}</th>
                    <th></th>
                </tr>
                </thead>
                @foreach ($user->transferRequests()->get() as $ticket_transfer)
                    <tr>
                        <td>{{ $ticket_transfer->original_full_name }}</td>
                        <td>{{ $ticket_transfer->full_name }}</td>
                        <td>{{ $ticket_transfer->formatted_status }}</td>
                        <td>
                            @if (!$ticket_transfer->completed)
                                <a class="button tiny secondary"
                                   href="{{ url('transfers/' . $ticket_transfer->id . '/edit') }}">
                                    {{ __('system.transfer_edit') }}
                                </a>&nbsp;
                                <button type="button" class="button tiny danger cancel-ticket"
                                        @click="deleteItem('transfers', {{ $attendee->id }})">
                                    {{ __('system.transfer_cancel') }}
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
        <div class="text-wrap">
            <a class="button primary" href="{{ route('backend.users.index') }}">{{ __('system.back') }}</a>
        </div>
        <keep-alive>
            <div :is="modalView" :row-data="rowData" @modal-closed="clearModal"
                 @exception-occured="showException"></div>
        </keep-alive>
    </div>
@endsection

@push('scripts')
    <script type="text/html" id="attendee-details">
        <div class="reveal" id="details-modal" data-reveal>
            <h3><i class="fa fa-pencil" aria-hidden="true"></i> {{ __('system.edit') }}</h3>
            <form method="POST" data-abide novalidate>
                @include('partials.error')
                <div class="grid-x grid-padding-x vuetable-form">
                    <div class="small-12 medium-3 cell">
                        <label class="text-right">{{ __('system.full_name') }}</label>
                    </div>
                    <div class="small-3 medium-2 cell">
                        <select name="title" id="title" v-model="editData.title" required>
                            @foreach (__('system.titles') as $title)
                                <option value="{{ $title }}">{{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="small-5 medium-4 cell">
                        <input type="text" name="first_name" id="first_name" pattern="text" v-model="editData.first_name"
                               required>
                    </div>
                    <div class="small-4 medium-3 cell">
                        <input type="text" name="last_name" id="last_name" pattern="text" v-model="editData.last_name"
                               required>
                    </div>
                    <div class="small-12 medium-3 cell">
                        <label class="text-right">{{ __('system.email') }}</label>
                    </div>
                    <div class="small-12 medium-9 cell">
                        <input type="email" name="email" id="email" pattern="email" v-model="editData.email" required>
                    </div>
                    <div class="small-12 medium-3 cell">
                        <label class="text-right">{{ __('system.type') }}</label>
                    </div>
                    <div class="small-12 medium-9 cell">
                        <select name="tickets" id="tickets" v-model="editData.ticket.id" required>
                            @foreach (\Jano\Models\Ticket::all() as $ticket)
                                <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="small-12 cell">
                        <div class="float-right">
                            <button id="submit" type="submit" class="button warning" @click="submit">
                                {{ __('system.update') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <button class="close-button" @click="close" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </script>
    <script type="text/html" id="exception">
        <div class="reveal" id="exception-modal" data-reveal>
            <h3><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ __('system.exception_title') }}</h3>
            {{ __('system.exception_message') }}
            <button class="close-button" @click="close" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </script>
    <script type="text/javascript">
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

        function findRow(attendees, id) {
            for (let i = 0, len = attendees.length; i < len; i++) {
                if (attendees[i].id === id)
                    return attendees[i];
            }

            return null;
        }

        $(document).ready(function() {
            @if ($user->attendees()->count() !== 0)
            Vue.component('attendee-details-modal', {
                template: '#attendee-details',
                data: function() {
                    return {
                        editData: {
                            title: '',
                            first_name: '',
                            last_name: '',
                            email: '',
                            ticket: {
                                id: 1
                            }
                        }
                    };
                },
                props: ['rowData'],
                methods: {
                    load: _.once(function() {
                        $('#details-modal').foundation();
                    }),
                    close: function() {
                        $('#details-modal').foundation('close');
                        this.$emit('modal-closed');
                    },
                    submit: function() {
                        event.preventDefault();

                        let error = false;

                        $('#details-modal').find('form').first().on('forminvalid.zf.abide', function(event, form) {
                            error = true;
                        }).foundation('validateForm');

                        if (error === true) {
                            return;
                        }

                        let parent = this;

                        axios.put('admin/attendees/' + this.$data.editData.id, this.$data.editData)
                            .then(function() {
                                $('#details-modal').html('<h3><i class="fa fa-check" aria-hidden="true"></i>'
                                    + '{{ __('system.update_success') }}</h3><button class="close-button" @click="close"'
                                    + ' type="button"><span aria-hidden="true">&times;</span></button>');
                                parent.$nextTick(function() {parent.$refs.vuetable.reload();});
                            })
                            .catch(function(error) {
                                if (error.response && error.response.status === '422') {
                                    processErrorBag(error.response.data.errors);
                                } else {
                                    $('#details-modal').foundation('close');
                                    parent.$emit('exception-occured');
                                }
                            });
                    }
                },
                activated: function(event) {
                    this.$data.editData = this.$props.rowData;
                    this.$nextTick();

                    this.load();
                    $('#details-modal').foundation('open');
                }
            });

            Vue.component('exception-modal', {
                template: '#exception',
                methods: {
                    load: _.once(function () {
                        $('#exception-modal').foundation();
                    }),
                    close: function() {
                        $('#exception-modal').foundation('close');
                        this.$emit('modal-closed');
                    },
                },
                activated: function(event) {
                    this.load();
                    $('#exception-modal').foundation('open');
                }
            });

            const vm = new Vue({
                el: '#user-show-container',
                data: {
                    modalView: '',
                    attendees: {!! json_encode($user->attendees()->with('ticket')->get()) !!},
                    rowData: {}
                },
                methods: {
                    editItem: function(model, id) {
                        this.$data.rowData = findRow(this.$data.attendees, id);
                        this.$data.modalView = model + '-details-modal';
                        this.$nextTick();
                    },
                    deleteItem: function(model, id) {
                        axios.delete('admin/' + model + '/' + id)
                            .then(function() {
                                location.reload();
                            })
                            .catch(function(error) {
                                alert(error.response.data);
                            });
                    },
                    clearModal: function() {
                        this.$data.rowData = {};
                        this.$data.modalView = '';
                        this.$nextTick();
                    },
                    showException: function() {
                        this.$data.modalView = 'exception-modal';
                        this.$nextTick();
                    }
                }
            });
            @endif
        });
    </script>
@endpush