@extends('layouts.backend')

@section('title', __('system.payments'))

@section('content')
<div id="data">
    <vuetable ref="vuetable" api-url="{{ route('backend.payments.index') }}" :fields="fields" pagination-path=""
        @vuetable:pagination-data="onPaginationData">
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
                    <label class="text-right">{{ __('system.amount_paid') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <input type="number" name="amount" id="amount" v-model="editData.amount" disabled>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.method') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <span class="field-content">@{{ editData.type }}</span>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.account') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <v-select :debounce="250" :on-search="getOptions" :options="options"
                              :value-sync="editData.account.id" label="account_id"></v-select>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.reference') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <input type="text" name="reference" id="reference" v-model="editData.reference" required>
                </div>
                <div class="small-12 medium-3 cell">
                    <label class="text-right">{{ __('system.internal_reference') }}</label>
                </div>
                <div class="small-12 medium-9 cell">
                    <input type="text" name="reference" id="reference" v-model="editData.internal_reference"
                           required>
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
                        amount: '',
                        type: '',
                        account: {
                          id: ''
                        },
                        reference: '',
                        internal_reference: ''
                    },
                    options: {}
                };
            },
            props: ['rowData'],
            methods: {
                load: _.once(function() {
                    $('#details-modal').foundation();
                }),
                getOptions: function(search, loading) {
                    loading(true);

                    axios.get('{{ route('backend.users.index') }}', {
                        params: {
                            q: search
                        }
                    }).then(function (response) {
                        loading(false);
                    });
                },
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

                    axios.put('backend/payments/' + this.$data.editData.id, this.$data.editData)
                        .then(function() {
                            $('#details-modal').html('<h3><i class="fa fa-check" aria-hidden="true"></i>'
                                + '{{ __('system.update_success') }}</h3><button class="close-button" @click="close"'
                                + ' type="button"><span aria-hidden="true">&times;</span></button>');
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
                fields: [
                    {
                        name: 'id',
                        visible: false,
                    },
                    {
                        name: '__checkbox'
                    },
                    {
                        name: 'full_amount',
                        sortField: 'amount',
                        title: '{{ __('system.amount_paid') }}'
                    },
                    {
                        name: 'type',
                        sortField: 'type',
                        title: '{{ __('system.method') }}'
                    },
                    {
                        name: 'reference',
                        sortField: 'reference',
                        title: '{{ __('system.reference') }}'
                    },
                    {
                        name: 'internal_reference',
                        visible: false,
                    },
                    {
                        name: '__slot:actions',
                        title: ''
                    }
                ]
            },
            methods: {
                onPaginationData: function(paginationData) {
                    this.$refs.pagination.setPaginationData(paginationData);
                    this.$refs.paginationInfo.setPaginationData(paginationData);
                },
                onChangePage: function(page) {
                    this.$refs.vuetable.changePage(page);
                },
                editItem: function(data) {
                    this.$data.rowData = data;
                    this.$data.modalView = 'details-modal';
                    this.$nextTick();
                },
                deleteItem: function(data) {
                    axios.delete('backend/payments/' + data.id)
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