@extends('layouts.backend')

@section('title', __('system.users'))

@section('content')
<div id="data">
    <div class="actions row">
        <div class="col-sm-12 offset-md-6 col-md-6 offset-lg-8 col-lg-4">
            <div class="input-group">
                <input type="text" v-model="filterText" class="form-control" @keydown="doFilter"
                       placeholder="{{ __('system.search') }}">
                <div class="input-group-append">
                    <button class="btn btn-warning" @click="resetFilter">{{ __('system.reset') }}</button>
                </div>
            </div>
        </div>
    </div>
    <vuetable ref="vuetable" api-url="{{ route('backend.users.index') }}" :fields="fields" :append-params="param"
        pagination-path="" @vuetable:pagination-data="onPaginationData">
        <template slot="actions" scope="props">
            <div class="table-actions">
                <div class="btn-group btn-group-sm">
                    <a class="btn btn-primary" :href="'{{ url('admin/users') }}/' + props.rowData.id">
                        <i class="fas fa-search fa-fw" aria-hidden="true"></i>
                    </a>
                    <button class="btn btn-warning" @click="editItem(props.rowData)">
                        <i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </template>
    </vuetable>
    <div class="vuetable-pagination row">
        <div class="col-sm-12 col-md-6">
            <vuetable-pagination-info ref="paginationInfo"></vuetable-pagination-info>
        </div>
        <div class="col-sm-12 col-md-6">
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
    <div class="modal fade" id="details-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="fas fa-pencil-alt" aria-hidden="true"></i> {{ __('system.edit') }}
                    </h4>
                    <button type="button" class="close" @click="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        @include('partials.error')
                        <div class="row form-group">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('system.full_name') }}</label>
                            <div class="col-sm-3 col-md-2">
                                <select name="title" id="title" class="custom-select" v-model="editData.title" required>
                                    @foreach (__('system.titles') as $title)
                                        <option value="{{ $title }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-5 col-md-4">
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                       pattern="text" v-model="editData.first_name" required>
                            </div>
                            <div class="col-sm-4 col-md-3">
                                <input type="text" name="last_name" id="last_name" class="form-control" pattern="text"
                                       v-model="editData.last_name" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('system.email') }}</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="email" name="email" id="email" class="form-control" pattern="email"
                                    v-model="editData.email" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-12 col-md-3 col-form-label">{{ __('system.group') }}</label>
                            <div class="col-sm-12 col-md-9">
                                <select name="group" id="group" class="custom-select" v-model="editData.group.id"
                                    required>
                                    @foreach (\Jano\Models\Group::all() as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <div class="text-right">
                                    <button id="submit" type="submit" class="btn btn-warning" @click="submit($event)">
                                        {{ __('system.update') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="exception">
    <div class="modal fade" id="exception-modal" tabindex="-1" role="document">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ __('system.exception_title') }}
                    </h4>
                    <button type="button" class="close" @click="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('system.exception_message') }}
                </div>
            </div>
        </div>
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
                        group: {
                            id: 1
                        }
                    }
                };
            },
            props: ['rowData'],
            methods: {
                load: _.once(function() {
                    $('#details-modal').modal();
                }),
                close: function() {
                    $('#details-modal').modal('hide');
                    this.$emit('modal-closed');
                },
                submit: function(event) {
                    event.preventDefault();

                    let error = false;

                    $('#details-modal').find('form').first().on('forminvalid.zf.abide', function(event, form) {
                        error = true;
                    }).foundation('validateForm');

                    if (error === true) {
                        return;
                    }

                    let parent = this;

                    axios.put('/admin/users/' + this.$data.editData.id, this.$data.editData)
                        .then(function() {
                            $('#details-modal').html('<h3><i class="fa fa-check" aria-hidden="true"></i> '
                                + '{{ __('system.update_success') }}</h3><button class="close-button" @click="close"'
                                + ' type="button"><span aria-hidden="true">&times;</span></button>');
                            parent.$nextTick(function() {parent.$refs.vuetable.reload();});
                        })
                        .catch(function(error) {
                            if (error.response && error.response.status === '422') {
                                processErrorBag(error.response.data.errors);
                            } else {
                                $('#details-modal').modal('hide');
                                parent.$emit('exception-occured');
                            }
                        });
                }
            },
            activated: function(event) {
                this.$data.editData = this.$props.rowData;
                this.$nextTick();

                this.load();
                $('#details-modal').modal('show');
            }
        });

        Vue.component('exception-modal', {
            template: '#exception',
            methods: {
                load: _.once(function () {
                    $('#exception-modal').modal();
                }),
                close: function() {
                    $('#exception-modal').modal('hide');
                    this.$emit('modal-closed');
                },
            },
            activated: function(event) {
                this.load();
                $('#exception-modal').modal('show');
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
                        name: 'first_name',
                        sortField: 'first_name',
                        title: '{{ __('system.first_name') }}'
                    },
                    {
                        name: 'last_name',
                        sortField: 'last_name',
                        title: '{{ __('system.last_name') }}'
                    },
                    {
                        name: 'email',
                        visible: false,
                    },
                    {
                        name: 'group.name',
                        sortField: 'group.name',
                        title: '{{ __('system.group') }}'
                    },
                    {
                        name: 'account.full_amount_outstanding',
                        sortField: 'account.amount_outstanding',
                        title: '{{ __('system.amount_outstanding') }}'
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
