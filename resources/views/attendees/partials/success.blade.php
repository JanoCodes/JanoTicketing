<div>
    <h2>{{ __('system.order_confirmed') }}</h2>
    <p>{{ __('system.order_confirmed_message') }}</p>
    <h3>{{ __('system.attendees') }}</h3>
    <table class="hover">
        <tbody>
        <tr v-for="attendee in attendees">
            <td>
                <strong>@{{ attendee.title }} @{{ attendee.first_name }} @{{ attendee.last_name }}</strong><br />
                <i>@{{ attendee.ticket.name }}</i><br />
                @{{ attendee.email }}
            </td>
            <td>
                <strong>@{{ attendee.full_user_ticket_price }}</strong>
            </td>
        </tr>
        </tbody>
        <tfoot class="total-price">
        <tr>
            <td></td>
            <td>@{{ totalPrice }}</td>
        </tr>
        </tfoot>
    </table>
    <div class="spacer"></div>
</div>