@extends('layouts.backend')

@section('title', __('system.home'))

@section('content')
<div class="clearfix">&nbsp;</div>
<div class="grid-x grid-padding-x" id="dashboard">
    <div class="small-12 medium-7 large-9 cell">
        <table>
            <thead>
            <tr>
                <td colspan="2">
                    <a href="{{ route('backend.attendees.index') }}">
                        {{ __('system.new_attendees') }}
                    </a>
                </td>
            </tr>
            <tr>
                <th>{{ __('system.full_name') }}</th>
                <th>{{ __('system.type') }}</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="attendee in attendees">
            <tr>
                <td>@{{ attendee.title }} @{{ attendee.first_name }} @{{ attendee.last_name }}</td>
                <td>@{{ attendee.ticket.name }}</td>
            </tr>
            </template>
            </tbody>
        </table>
    </div>
    <div class="small-12 medium-5 large-3 cell">
        <div class="callout">
            <small>
                <i class="fa fa-ticket fa-fw" aria-hidden="true"></i> {{ __('system.tickets_purchased') }}
            </small>
            <div class="stat">@{{ attendees_count }}</div>
        </div>
        <div class="callout">
            <small>
                <i class="fa fa-credit-card fa-fw" aria-hidden="true"></i> {{ __('system.total_charges') }}
            </small>
            <div class="stat">{{ Setting::get('payment.currency') }}@{{ charges_total }}</div>
        </div>
        <div class="callout">
            <small>
                <i class="fa fa-users fa-fw" aria-hidden="true"></i> {{ __('system.ticket_requests') }}
            </small>
            <div class="stat">@{{ requests_count }}</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    const vm = new Vue({
        el: '#dashboard',
        data: {
            attendees: [],
            attendees_count: '',
            charges_total: '',
            requests_count: ''
        },
        methods: {
            loadData: function() {
                const parent = this;

                axios.get('admin')
                    .then(function(response) {
                        const data = response.data;

                        parent.$data.attendees = data.attendees;
                        parent.$data.attendees_count = data.attendees_count;
                        parent.$data.charges_total = data.charges_total;
                        parent.$data.requests_count = data.requests_count;
                    });
            }
        },
        mounted: function() {
            this.loadData();
        }
    });
</script>
@endpush