@extends('layouts.backend')

@section('title', __('system.ticket_transfer_request'))

@section('content')
<div id="data">
    <div class="actions grid-x">
        <div class="small-12 medium-6 large-8 cell">
            <form method="POST" action="{{ route('backend.jobs.store') }}">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="command">
                <input type="hidden" name="value" value="transfers:process">
                <button type="submit" class="button hollow">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> {{ __('system.process_transfers') }}
                </button>
            </form>
        </div>
        <div class="small-12 medium-6 large-4 cell">
            <div class="input-group">
                <input type="text" v-model="filterText" class="input-group-field" @keydown="doFilter"
                       placeholder="{{ __('system.search') }}">
                <div class="input-group-button">
                    <button class="button warning" @click="resetFilter">{{ __('system.reset') }}</button>
                </div>
            </div>
        </div>
    </div>
    <vuetable ref="vuetable" api-url="{{ route('backend.transfers.index') }}" :fields="fields" :append-params="param"
        pagination-path="" @vuetable:pagination-data="onPaginationData">
        <template slot="actions" scope="props">
            <div class="table-actions">
                <button class="button small warning" @click="editItem(props.rowData)">
                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                </button>
                <button class="button small alert" @click="deleteItem(props.rowData)">
                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                </button>
            </div>
        </template>
    </vuetable>
    <div class="vuetable-pagination grid-x">
        <div class="small-12 medium-6 cell">
            <vuetable-pagination-info ref="paginationInfo"></vuetable-pagination-info>
        </div>
        <div class="small-12 medium-6 cell">
            <vuetable-pagination ref="pagination" @vuetable-pagination:change-page="onChangePage"></vuetable-pagination>
        </div>
    </div>
    <keep-alive>
        <div :is="modalView" :row-data="rowData" @modal-closed="clearModal" @exception-occured="showException"></div>
    </keep-alive>
</div>
@endsection

@push('scripts')
<script type="text/html" id="details">
    <div class="reveal" id="details-modal" data-reveal>
        <h3><i class="fa fa-pencil" aria-hidden="true"></i> {{ __('system.edit') }}</h3>
        <form method="POST" data-abide novalidate>
            @include('partials.error')
            <div class="grid-x grid-padding-x vuetable-form">
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.original_attendee') }}</label>
                </div>
                <div class="small-3 medium-2 cell">
                    <select name="title" id="title" v-model="editData.old_title" required>
                        @foreach (__('system.titles') as $title)
                            <option value="{{ $title }}">{{ $title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="small-5 medium-4 cell">
                    <input type="text" name="first_name" id="first_name" pattern="text"
                           v-model="editData.old_first_name" required>
                </div>
                <div class="small-4 medium-3 cell">
                    <input type="text" name="last_name" id="last_name" pattern="text"
                           v-model="editData.old_last_name" required>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.email') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <input type="email" name="email" id="email" pattern="email"
                           v-model="editData.old_email" required>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.new_attendee') }}</label>
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
    $(document).ready(function() {
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

        Vue.component('details-modal', {
            template: '#details',
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

                    axios.put('/admin/transfers/' + this.$data.editData.id, this.$data.editData)
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
            el: '#data',
            data: {
                modalView: '',
                rowData: '',
                filterText: '',
                fields: [
                    {
                        name: 'id',
                        visible: false,
                    },
                    {
                        name: '__checkbox'
                    },
                    {
                        name: 'old_first_name',
                        sortField: 'old_first_name',
                        title: '{{ __('system.first_name') }}'
                    },
                    {
                        name: 'old_last_name',
                        sortField: 'old_last_name',
                        title: '{{ __('system.last_name') }}'
                    },
                    {
                        name: 'first_name',
                        sortField: 'first_name',
                        title: '{{ __('system.first_name') }}'
                    },
                    {
                        name: 'last_name',
                        sortField: 'lasts_name',
                        title: '{{ __('system.last_name') }}'
                    },
                    {
                        name: 'email',
                        visible: false,
                    },
                    {
                        name: '__slot:actions',
                        title: ''
                    }
                ],
                param: {}
            },
            methods: {
                onPaginationData: function(paginationData) {
                    this.$refs.pagination.setPaginationData(paginationData);
                    this.$refs.paginationInfo.setPaginationData(paginationData);
                },
                onChangePage: function(page) {
                    this.$refs.vuetable.changePage(page);
                },
                doFilter: _.debounce(function() {
                    this.$data.param = {
                        q: this.$data.filterText
                    };
                    this.$nextTick(function() {this.$refs.vuetable.refresh();});
                }, 250),
                resetFilter: function() {
                    this.$data.filterText = '';
                    this.$data.param = {};
                    this.$nextTick(function() {this.$refs.vuetable.refresh();});
                },
                editItem: function(data) {
                    this.$data.rowData = data;
                    this.$data.modalView = 'details-modal';
                    this.$nextTick();
                },
                deleteItem: function(data) {
                    axios.delete('/admin/transfers/' + data.id)
                        .then(function() {
                            this.$refs.vuetable.reload();
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
    });
</script>
@endpush