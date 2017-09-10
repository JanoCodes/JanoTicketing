@extends('layouts.backend')

@section('title', __('system.about'))

@section('content')
<div class="text-wrap">
    <h2>{{ __('system.jano_ticketing_system') }}</h2>
    <p>{{ __('system.about_copyright') }}</p>
    <p>{!! __('system.about_license') !!}</p>
    <div class="credits" id="credits">
        {!! $credits !!}
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        const credits = $('#credits');

        credits.animate(
            {scrollTop: credits.prop('scrollHeight') - credits.height()},
            (credits.prop('scrollHeight') - credits.height()) * 25,
            'linear',
            () => credits.css('overflow-y', 'scroll')
        );
    });
</script>
@endpush