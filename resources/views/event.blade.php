@extends('layouts.app')

@section('title', __('system.create_order'))

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-7 col-lg-8">
            <div class="card event-card">
                <div class="event-cover" style="background-image:
                        url({{ asset('images/' . Setting::get('event.cover_image')) }});">&nbsp;</div>
                <div class="event-info">
                    <h2 class="event-name">{{ Setting::get('event.name') }}</h2>
                </div>
                <div class="card-body text-center event-details">
                    <h5>{{ $event_date['from']->format('j M, Y g:i a') }} {{ __('system.to') }} {{ $event_date['to']->format('j M, Y g:i a') }}</h5>
                    {{ Setting::get('event.location.name') }}
                    <div class="event-map" id="map">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3>{{ __('system.order_tickets') }}</h3>
                    @include('partials.error')
                    @can('create', Jano\Models\Attendee::class)
                        <div class="table-scroll">
                            <form method="GET" action="{{ route('attendees.create') }}" id="form" data-abide
                                  novalidate>
                                {{ csrf_field() }}
                                <table class="table table-hover tickets">
                                    <thead>
                                    <tr>
                                        <th>{{ __('system.type') }}</th>
                                        <th>{{ __('system.quantity') }}</th>
                                    </tr>
                                    </thead>
                                    @each('partials.ticket', $tickets, 'ticket', 'partials.ticket-empty')
                                    <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <div class="btn-group">
                                                <a class="btn btn-warning" href="{{ url('/') }}">
                                                    {{ __('system.back') }}
                                                </a>
                                                <button class="btn btn-primary" name="submit" value="true"
                                                        type="submit">
                                                    {{ __('system.next') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                    @else
                    <p>You're not yet able to order tickets. Please return on {{ $user->can_order_at }}</p>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            localStorage.removeItem('jano_{{ snake_case(config('app.name')) }}');

            function onUpdateQuantity() {
                let sum = 0;

                $('input#tickets').each(function() {
                    sum += parseInt($(this).val());
                });

                if (sum > {{ Auth::user()->ticket_limit }}) {
                    $('[data-quantity="plus"]').each(function (index, element) {
                        $(element).prop('disabled', true);
                    });
                    $('[data-abide-error]').html("{{ __('system.ticket_limit_exceeded') }}").show();
                    $('[name=submit]').prop('disabled', true);
                } else {
                    $('[data-quantity="plus"]').each(function (index, element) {
                        $(element).prop('disabled', false);
                    });
                    $('[data-abide-error]').hide();
                    $('[name=submit]').prop('disabled', false);
                }
            }

            $('input#tickets').on('change', function() {
                onUpdateQuantity();
            });

            $('[data-quantity="plus"]').click(function(e){
                e.preventDefault();
                let currentVal = parseInt($(this).closest('.input-group').find('input').val());
                if (!isNaN(currentVal)) {
                    $(this).closest('.input-group').find('input').val(currentVal + 1);
                    onUpdateQuantity();
                } else {
                    $(this).closest('.input-group').find('input').val(0);
                }
            });
            $('[data-quantity="minus"]').click(function(e) {
                e.preventDefault();
                let currentVal = parseInt($(this).closest('.input-group').find('input').val());
                if (!isNaN(currentVal) && currentVal > 0) {
                    $(this).closest('.input-group').find('input').val(currentVal - 1);
                    onUpdateQuantity();
                } else {
                    $(this).closest('.input-group').find('input').val(0);
                    onUpdateQuantity();
                }
            });
        });
    </script>
@endpush


@push('scripts')
    <script>
        mapboxgl.accessToken = '{{ Setting::get('mapbox.access_token') }}';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v10',
            center: [{{ Setting::get('event.location.long') }}, {{ Setting::get('event.location.lat') }}],
            zoom: 14,
            minZoom: 13,
            attributionControl: false
        })
            .addControl(new mapboxgl.AttributionControl({
                compact: false
            }));
    </script>
@endpush