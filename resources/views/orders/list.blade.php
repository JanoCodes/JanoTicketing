@extends('layouts.app')

@section('title', __('system.ticket_orders'))

@section('content')
    <div class="grid-x grid-padding-x cell">
        <h3>{{ __('system.ticket_orders') }}</h3>
        <table>
            <thead>
            <tr>
                <th></th>
                <th>{{ __('system.status') }}</th>
                <th></th>
            </tr>
            </thead>
            @foreach ($orders as $order)
            <tr>
                <td>
                    <h4>{{ __('system.order') }} #{{ $order->id }}</h4>
                    {{ $order->attendees()->count() }}&nbsp;
                    {{ $order->attendees()->count() > 1 ? __('system.attendees') : __('system.attendee')}}<br />
                    {{ Helper::getFullPrice($order->amount_due) }}
                </td>
                <td>
                    {{ $order->formatted_status }}
                </td>
                <td>
                    <a class="button tiny secondary" href="{{ url('orders/' . $order->id) }}">
                        {{ __('system.view_details') }}
                    </a>
                    @if ($order->amount_paid === 0)
                    <a class="button tiny danger cancel-order" data-cancel data-cancel-object="orders"
                       data-cancel-object-id="{{ $order->id }}" href="#">
                        {{ __('system.cancel_order') }}
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="small reveal" id="cancel-order-container" data-reveal>
        <p class="lead text-alert">
            <strong>{{ __('system.cancel_alert', ['attribute' => strtolower('system.order')]) }}</strong><br />
            <small>{{ __('system.cancel_small') }}</small>
        </p>
        <form role="form" method="POST" action="#">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="button" class="alert button">{{ __('system.continue') }}</button>
            <button class="secondary button" href="#" data-close>{{ __('system.back') }}</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('[data-cancel]').each(function() {
            this.on('click', function(e) {
                e.preventDefault();

                var object = this.data('cancel-object');
                $('#cancel-' + object + '-container')
                    .foundation('open')
                    .children('form')
                    .attr('action', object + '/' + this.data('cancel-object-id'));

            })
        });
    </script>
@endpush