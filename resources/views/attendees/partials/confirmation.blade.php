<form id="form" data-abide novalidate>
    <h3>{{ __('system.your_details') }}</h3>
    <div class="grid-x grid-padding-x">
        <div class="small-12 medium-4 cell">
            {{ __('system.full_name') }}
        </div>
        <div class="small-12 medium-8 cell">
            @{{ title }} @{{ first_name }} @{{ last_name }}
        </div>
        <div class="small-12 medium-4 cell">
            {{ __('system.email') }}
        </div>
        <div class="small-12 medium-8 cell">
            @{{ email }}
        </div>
        <div class="small-12 medium-4 cell">
            {{ __('system.phone') }}
        </div>
        <div class="small-12 medium-8 cell">
            @{{ phone }}
        </div>
    </div>
    <div class="spacer"></div>
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
                    <strong>@{{ attendee.ticket.full_price }}</strong>
                </td>
            </tr>
        </tbody>
        <tfoot class="total-price">
            <tr>
                <td></td>
                <td>@{{ getTotalPrice }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="spacer"></div>
    <label class="agreement">
        <input name="agreement" id="agreement" value="1" type="checkbox" v-model="agreement"
            v-on:click="agreementUpdate" required>&nbsp;&nbsp;&nbsp;{{ Setting::get('agreement') }}
    </label>
    <span class="form-error">
        <strong>
            {{ __('validation.agreement', ['attribute' => strtolower(__('system.agreement'))]) }}
        </strong>
    </span>
    <div class="spacer"></div>
</form>