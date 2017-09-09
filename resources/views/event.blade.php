@extends('layouts.app')

@section('title', __('system.create_order'))

@section('content')
    <div class="grid-x">
        <div class="small-12 medium-7 large-8 cell">
            <div class="card event-card">
                <div class="event-cover" style="background-image:
                        url({{ asset('images/' . Setting::get('event.cover_image')) }});" />&nbsp;</div>
                <div class="event-info">
                    <span>
                        <h2>{{ Setting::get('event.name') }}</h2>
                    </span>
                </div>
                <div class="card-section text-center">
                    Location: Secret
                    <div class="event-map" id="map">
                        <iframe width="100%" height="100%" frameborder="0" style="border:0"
                                src="https://www.google.com/maps/embed/v1/view?key=
                            {{ Setting::get('system.google_maps_key') }}&center=52.2005954,0.1214614
                            &zoom=12">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-12 medium-5 large-4 cell">
            <div class="callout event-side">
                <h3>{{ __('system.order_tickets') }}</h3>
                @include('partials.error')
                <div class="table-scroll">
                    <form method="GET" action="{{ route('attendees.create') }}" id="form" data-abide
                        novalidate>
                        {{ csrf_field() }}
                        <table class="hover tickets">
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
                                    <a class="button warning" href="{{ url('/') }}">
                                        {{ __('system.back') }}
                                    </a>
                                    <button class="button" name="submit" value="true"
                                        type="submit">
                                        {{ __('system.next') }}
                                    </button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            function onUpdateQuantity() {
                let sum = 0;

                $('input#tickets').each(function() {
                    sum += parseInt($(this).val());
                });

                if (sum >= {{ Auth::user()->ticket_limit }}) {
                    $('[data-quantity="plus"]').each(function (index, element) {
                        $(element).prop('disabled', true);
                    });
                    $('[data-abide-error]').html("{{ __('system.ticket_limit_reached') }}").show();
                    $('[name=submit]').prop('disabled', true);
                } else {
                    $('[data-quantity="plus"]').each(function (index, element) {
                        $(element).prop('disabled', false);
                    });
                    $('[data-abide-error]').html("{{ __('system.ticket_limit_reached') }}").hide();
                    $('[name=submit]').prop('disabled', false);
                }
            }

            $('input#tickets').on('change', function() {
                onUpdateQuantity();
            });

            $('[data-quantity="plus"]').click(function(e){
                e.preventDefault();
                var currentVal = parseInt($(this).closest('.input-group').find('input').val());
                if (!isNaN(currentVal)) {
                    $(this).closest('.input-group').find('input').val(currentVal + 1);
                    onUpdateQuantity();
                } else {
                    $(this).closest('.input-group').find('input').val(0);
                }
            });
            $('[data-quantity="minus"]').click(function(e) {
                e.preventDefault();
                var currentVal = parseInt($(this).closest('.input-group').find('input').val());
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