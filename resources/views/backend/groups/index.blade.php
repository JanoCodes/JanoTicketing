@extends('layouts.backend')

@section('title', __('system.groups'))

@section('content')
<div id="data">
    <div class="actions grid-x">
        <div class="small-12 medium-6 large-8 cell">
            <a class="button hollow" href="{{ route('backend.groups.create') }}">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> {{ __('system.new_entry') }}
            </a>
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
    <vuetable ref="vuetable" api-url="{{ route('backend.groups.index') }}" :fields="fields" :append-params="param"
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
                    <label class="text-right">{{ __('system.slug') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <span class="field-content">@{{ editData.slug }}</span>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.group') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <input type="text" name="name" id="name" v-model="editData.name" required>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.ticket_order_begins') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <input type="text" name="can_order_at" id="can_order_at"
                           v-model="editData.can_order_at" required>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.ticket_limit') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <input type="number" name="ticket_limit" id="ticket_limit" pattern="integer"
                           v-model="editData.ticket_limit" required>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.surcharge') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <div class="input-group">
                        <span class="input-group-label">{{ Setting::get('payment.currency') }}</span>
                        <input name="amount" id="amount" class="input-group-field" type="number"
                               pattern="integer" v-model="editData.surcharge" required>
                    </div>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.right_to_buy') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <div class="input-group">
                        <input name="right_to_buy" id="right_to_buy" class="input-group-field"
                               type="number" pattern="integer" v-model="editData.right_to_buy" required>
                        <span class="input-group-label">{{ __('system.ticket_s') }}</span>
                    </div>
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
                        slug: '',
                        name: '',
                        can_order_at: '',
                        ticket_limit: '',
                        surcharge: '',
                        right_to_buy: ''
                    }
                };
            },
            props: ['rowData'],
            methods: {
                load: _.once(function() {
                    $('#details-modal').foundation();

                    $('#can_order_at').flatpickr({
                        altFormat: 'j M Y h:i K',
                        altInput: true,
                        dateFormat: 'd/m/Y',
                        enableTime: true
                    });
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

                    axios.put('admin/tickets/' + this.$data.editData.id, this.$data.editData)
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
                        name: 'name',
                        sortField: 'name',
                        title: '{{ __('system.group') }}'
                    },
                    {
                        name: 'ticket_limit',
                        sortField: 'ticket_limit',
                        title: '{{ __('system.ticket_limit') }}'
                    },
                    {
                        name: 'full_surcharge',
                        sortField: 'surcharge',
                        title: '{{ __('system.surcharge') }}'
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
                    axios.delete('admin/tickets/' + data.id)
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