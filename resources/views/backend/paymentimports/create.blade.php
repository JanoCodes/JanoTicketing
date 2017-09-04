@extends('layouts.backend')

@section('title', __('system.import_entries'))

@section('content')
<div class="clearfix">&nbsp;</div>
<div class="grid-x grid-padding-x">
    <div class="small-offset-1 small-10 large-offset-2 large-8 cell dz-container">
        <div id="upload-success" class="alert alert-success callout" style="display: none;">
            {{ __('system.upload_success_message') }}
        </div>
        <div class="grid-x grid-margin-x dz-files">
            <form role="form" id="payment-files-upload" method="POST" action="{{ route('backend.paymentimports.store') }}"
                class="dropzone" data-abide novalidate>
                @include('partials.error')
                {{ csrf_field() }}
                <input type="hidden" name="file" required />
                <div class="dz-message">
                    <h3>{{ __('system.upload_files_prompt') }}</h3>
                    <span class="accepted-file">
                        {{ __('system.accepted_file_types', ['extensions' => '.csv']) }}
                    </span>
                </div>
            </form>
        </div>
    </div>
    <div class="small-offset-1 small-10 large-offset-2 large-8 cell text-right">
        <div class="clearfix">&nbsp;</div>
        <a class="button warning" href="{{ route('backend.payments.index') }}">{{ __('system.back') }}</a>
        <button class="button" id="start-upload">{{ __('system.upload') }}</button>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/html" id="file-template">
    <div class="dz-preview dz-file-preview">
        <button class="float-right dz-remove" type="button" data-dz-remove>
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="dz-details">
            <div class="dz-filename" data-dz-name></div>
            <small class="dz-size" data-dz-size></small>
        </div>
        <div class="progress dz-progress" role="progressbar">
            <div class="progress-meter dz-upload" data-dz-uploadprogress></div>
        </div>
    </div>
</script>
<script type="text/html" id="upload-error-template">
    <div class="dz-status">
        <div class="dz-status-icon">
            <i class="fa fa-exclamation-circle fa-2x fa-fw" aria-hidden="true"></i>
        </div>
        <div class="dz-status-message">
            {{ __('system.upload_error_message') }}
        </div>
    </div>
</script>
<script type="text/html" id="upload-success-template">
    <div class="dz-status">
        <div class="dz-status-icon dz-success">
            <i class="fa fa-check-circle fa-2x fa-fw" aria-hidden="true"></i>
        </div>
    </div>
</script>
<script type="text/html" id="definitions-reveal">
    <div class="reveal" id="dz-definitions" data-reveal data-close-on-click="false" data-close-on-esc="false"
        data-reset-on-close="true">
        <div data-abide-error role="alert" class="alert callout" style="display: none;"></div>
        {!! __('system.upload_column_match_message') !!}
        <div class="table-scroll">
            <table class="dz-definitions-table">
                <tr>
                    <template v-for="column in file.columns">
                        <td>
                            <select @change="onChange(this)" :data-column="column">
                                <template v-for="option in options">
                                    <option :value="option">@{{ option }}</option>
                                </template>
                            </select>
                        </td>
                    </template>
                    <td class="row-collapse" rowspan="3" style="display: none;">
                        <button class="clear button" @click="expandTable">
                            <i class="fa fa-ellipsis-h fa-2x" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
                <thead>
                <tr>
                    <template v-for="column in file.columns">
                        <th>@{{ column }}</th>
                    </template>
                </tr>
                </thead>
                <tr>
                    <template v-for="data in file.sample">
                        <td>@{{ data }}</td>
                    </template>
                </tr>
            </table>
            <button class="button" @click="submitForm">{{ __('system.continue') }}</button>
        </div>
    </div>
</script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;

    $(document).ready(function() {
        let dropzone = new Dropzone('#payment-files-upload', {
            previewTemplate: $('#file-template').html(),
            autoProcessQueue: false,
            createImageThumbnails: false,
        });

        dropzone.on('drop', function(file) {
            $('.dz-message').hide();
        });
        dropzone.on('reset', function(file) {
            $('.dz-message').show();
        });
        dropzone.on('success', function(file) {
            file.previewTemplate.appendChild($('#upload-success-template').html());
            dropzone.processQueue();
        });
        dropzone.on('error', function(file, message, xhr) {
            let response = JSON.parse(xhr.responseText);

            if (response === null || response.file === null) {
                file.previewTemplate.appendChild($('#upload-error-template').html());
                dropzone.processQueue();
            } else {
                file.previewTemplate.appendChild('<div data-file="' + file.name + '"></div>');

                const options = Object.keys(response.file.matches);

                const vm = new Vue({
                    el: '[data-file="' + file.name + '"]',
                    template: $('#definitions-reveal').html(),
                    data: {
                        name: file.name,
                        file: response.file,
                        options: options,
                        definitions: response.file.matches
                    },
                    methods: {
                        onChange: function(object) {
                            let field = $(object).val();

                            if (field) {
                                this.$data.definitions[field] = $(object).data('column');
                            }

                            let selected = [];

                            $('select').each(function() {
                                selected.push($(this).val());
                            });

                            $.each(this.$data.options, function(i, value) {
                                $('option[value=' + value + ']').prop('disabled', false);
                            });
                            $.each(selected, function(i, value) {
                                $('option[value=' + value + ']').prop('disabled', true);
                            });
                        },
                        expandTable: function() {
                            const table = $(this.$el).child('table');
                        },
                        submitForm: function() {
                            const parent = this;

                            axios.put('{{ route('backend.paymentimports.update') }}', {
                                file: this.$data.file.name,
                                definitions: this.$data.definitions
                            }).then(function(response) {
                                $(parent.$el).foundation('close');
                                parent.$destroy();
                            }).catch(function(error) {
                                $('[data-abide-error]').html(
                                    '<p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '
                                    + error.response.data.error + '</p>').show();
                            });
                        }
                    },
                    mounted: function() {
                        $.each(this.$data.options, function(i, value) {
                            $('option[value=' + value + ']').prop('disabled', false);
                        });
                        $.each(this.$data.definitions, function(i,value) {
                            $('select[data-column=' + value + ']').val(i);
                            $('option[value=' + i + ']').prop('disabled', true);
                        });

                        $('.dz-definitions').foundation().foundation('open');

                        const revealWidth = $(this.$el).width();
                        const table = $(this.$el).child('table');

                        if (table.width() > revealWidth) {
                            table.child('.collapse').show();
                            const child = table.child('tr').first().child('td').get();

                            for (let i = child.length() - 1; table.width() > revealWidth; i--) {
                                table.child('td:nth-child(' + i + ')').hide();
                            }
                        }
                    }
                });
            }
        });
        dropzone.on('queuecomplete', function() {
            $('#upload-success').show();
            $('#start-upload').prop('disabled', true);
        });

        $('#start-upload').on('click', function() {
            dropzone.processQueue();
            $(this).prop('disabled', true);
        });
    });
</script>
@endpush