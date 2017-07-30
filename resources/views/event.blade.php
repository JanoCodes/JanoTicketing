@extends('layouts.app')

@section('title', __('system.create_order'))

@section('content')
    @include('partials.error')
    <div class="table-scroll">
        <form method="GET" action="{{ route('attendees.create') }}" id="form" data-abide novalidate>
            {{ csrf_field() }}
            <table class="hover tickets">
                <thead>
                    <tr>
                        <th>{{ __('system.type') }}</th>
                        <th>{{ __('system.price') }}</th>
                        <th>{{ __('system.quantity') }}</th>
                    </tr>
                </thead>
                @each('partials.ticket', $tickets, 'ticket', 'partials.ticket-empty')
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">
                            <button class="button button-primary" name="submit" value="true" type="submit">
                                {{ __('system.next') }}
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            function onUpdateQuantity() {
                var sum = 0;

                $('input#tickets').each(function() {
                    sum += $(this).val();
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

            $('input#tickets').change(function() {
                onUpdateQuantity();
            });

            $('[data-quantity="plus"]').click(function(e){
                e.preventDefault();
                var currentVal = parseInt($(this).closest('.input-group').find('input').val());
                console.log(currentVal);
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