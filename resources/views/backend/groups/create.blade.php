@extends('layouts.backend')

@section('title', __('system.create_group'))

@section('content')
<div class="clearfix">&nbsp;</div>
@include('partials.error')
{!! form($form) !!}
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#can_order_at').flatpickr({
            altFormat: 'j M Y h:i K',
            altInput: true,
            dateFormat: 'd/m/Y',
            enableTime: true
        });
    });
</script>
@endpush
