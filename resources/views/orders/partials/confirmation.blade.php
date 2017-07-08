<div>
    <h3>{{ __('system.your_details') }}</h3>
    <div class="grid-x grid-padding-x">
        <div class="small-12 medium-4 cell">
            {{ __('system.full_name') }}
        </div>
        <div class="small-12 medium-8 cell">
            @{{ full_name }}
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
        <tr v-for="attendee in attendees">
            <td>
                <strong>@{{ attendee.full_name }}</strong><br />
                <i>@{{ getTicketType(attendee.ticket) }}</i><br />
                @{{ attendee.email }}
            </td>
            <td>
                <strong>@{{ getTicketPrice(attendee.ticket, attendee.charity_donation) }}</strong>
            </td>
        </tr>
    </table>
    <div class="spacer"></div>
    <label for="agreement">
        <input name="agreement" id="agreement" value="1" type="checkbox" v-model="agreement" v-on="agreementUpdate"
               required>&nbsp;
        {!! Setting::get('system.agreement') !!}
    </label>
    <span class="form-error">
            <strong>
                {{ __('validation.agreement', ['attribute' => strtolower(__('system.agreement'))]) }}
            </strong>
        </span>
    <div class="spacer"></div>
</div>