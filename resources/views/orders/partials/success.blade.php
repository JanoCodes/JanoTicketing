<div>
    <h2>{{ __('system.order_confirmed') }}</h2>
    <h3>{{ __('system.attendees') }}</h3>
    <table class="hover">
        <tr v-for="attendee in committed.attendees">
            <td>
                <strong>@{{ attendee.fullName }}</strong><br />
                <i>@{{ attendee.ticket }}</i><br />
                @{{ attendee.email }}
            </td>
            <td>
                <strong>@{{ attendee.price }}</strong>
            </td>
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