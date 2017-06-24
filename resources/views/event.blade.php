@extends('layouts.app')

@section('title', __('system.home'))

@section('content')
    <div class="table-scroll">
        <table class="hover tickets">
            <tr>
                <th>{{ __('system.type') }}</th>
                <th>{{ __('system.price') }}</th>
                <th>{{ __('system.quantity') }}</th>
            </tr>
            <tr>
                <td>Standard</td>
                <td>$200</td>
                <td>
                    <div class="input-group">
                        <span class="input-group-label">
                            <a class="icon" href="#" data-quantity="plus">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </span>
                        <input type="number" name="tickets[]" value="0">
                        <span class="input-group-label">
                            <a class="icon" href="#" data-quantity="minus">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </a>
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Standard</td>
                <td>$200</td>
                <td>
                </td>
            </tr>
        </table>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-quantity="plus"]').click(function(e){
                e.preventDefault();
                var currentVal = parseInt($(this).closest('.input-group').find('input').val());
                console.log(currentVal);
                if (!isNaN(currentVal)) {
                    $(this).closest('.input-group').find('input').val(currentVal + 1);
                } else {
                    $(this).closest('.input-group').find('input').val(0);
                }
            });
            $('[data-quantity="minus"]').click(function(e) {
                e.preventDefault();
                var currentVal = parseInt($(this).closest('input').val());
                if (!isNaN(currentVal) && currentVal > 0) {
                    $(this).closest('.input-group').find('input').val(currentVal - 1);
                } else {
                    $(this).closest('.input-group').find('input').val(0);
                }
            });
        });
    </script>
@endpush