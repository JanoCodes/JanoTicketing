<tr>
    <td>{{ $ticket->name }}</td>
    <td>{{ $ticket->price }}</td>
    <td>
        @if (!$ticket->soldout)
            <div class="input-group">
                <span class="input-group-label">
                    <a class="icon" href="#" data-quantity="plus">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </span>
                <input type="number" name="tickets[{{ $ticket->id }}]" id="tickets" value="0">
                <span class="input-group-label">
                    <a class="icon" href="#" data-quantity="minus">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </a>
                </span>
            </div>
        @else
            <span class="text-alert">{{ __('system.soldout') }}</span>
        @endif
    </td>
</tr>