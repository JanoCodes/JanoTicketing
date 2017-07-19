<div>
    <h2>{{ __('system.order_confirmed') }}</h2>
    <h3>{{ __('system.attendees') }}</h3>
    <table class="hover">
        <tr v-for="attendee in committed.attendees">
            <tbody>
                <td>
                    <strong>@{{ attendee.title }} @{{ attendee.first_name }} @{{ attendee.last_name }}</strong><br />
                    <i>@{{ attendee.ticket }}</i><br />
                    @{{ attendee.email }}
                </td>
                <td>
                    <strong>@{{ attendee.ticket.full_price }}</strong>
                </td>
            </tbody>
        </tr>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>@{{ committed.amount_due }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="spacer"></div>
</div>