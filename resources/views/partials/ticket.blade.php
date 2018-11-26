<tr>
    <td>
        <strong>{{ $ticket->name }}</strong><br />
        {{ \Jano\Repositories\HelperRepository::getUserPrice($ticket->price, Auth::user()) }}
    </td>
    <td>
        @if ($ticket->available)
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary ticket-plus" href="#" data-quantity="plus">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
                <input type="number" name="tickets[{{ $ticket->id }}]" class="form-control" id="tickets" value="0">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary ticket-minus" href="#" data-quantity="minus">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        @else
            <span class="text-alert">{{ __('system.soldout') }}</span>
        @endif
    </td>
</tr>