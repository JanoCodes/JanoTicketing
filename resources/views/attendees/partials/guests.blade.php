<form id="form" data-abide novalidate>
    <ul class="tabs" data-deep-link="true" data-deep-link-smudg="true" data-update-history="true" data-tabs
        id="attendees-tabs">
        <template v-for="(attendee, index) in attendees">
            <li class="tabs-title" :class="{ 'is-active': (index === 0) }" :id="'panellink' + index">
                <a :href="'#panel' + index" :aria-selected="{ 'true': (index === 0), 'false': (index !== 0) }">
                    {{ __('system.attendee') }} #@{{ index + 1 }}
                </a>
            </li>
        </template>
    </ul>
    <div class="tabs-content" data-tabs-content="attendees-tabs">
        <template v-for="(attendee, index) in attendees">
            <div class="tabs-panel" :class="{ 'is-active': (index === 0) }"
                 :id="'panel' + index">
                <div class="grid-x grid-padding-x">
                    <div class="small-12 medium-8 medium-offset-4 cell">
                        <input :name="'attendees.' + index + '.primary_ticket_holder'" id="primary_ticket_holder"
                               v-model="attendee.primary_ticket_holder"
                               v-on:click="primaryTicketHolderOnChange($event)" type="checkbox" value="1">
                        <label>{{ __('system.primary_ticket_holder') }}</label>
                    </div>
                    <div class="small-12 medium-4 cell">
                        <label class="text-right middle">{{ __('system.title') }}</label>
                    </div>
                    <div class="small-12 medium-8 cell">
                        <select :name="'attendees.' + index + '.title'" id="title" v-model="attendee.title" required>
                            @foreach (__('system.titles') as $title)
                                <option value="{{ $title }}">{{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="small-12 medium-4 cell">
                        <label class="text-right middle">{{ __('system.first_name') }}</label>
                    </div>
                    <div class="small-12 medium-8 cell">
                        <input type="text" :name="'attendees.' + index + '.first_name'" id="first_name"
                               v-model="attendee.first_name" pattern="text" required>
                        <span class="form-error">
                            <strong>
                                {{ __('validation.required', ['attribute' => strtolower(__('system.first_name'))]) }}
                            </strong>
                        </span>
                    </div>
                    <div class="small-12 medium-4 cell">
                        <label class="text-right middle">{{ __('system.last_name') }}</label>
                    </div>
                    <div class="small-12 medium-8 cell">
                        <input type="text" :name="'attendees.' + index + '.last_name'" id="last_name"
                               v-model="attendee.last_name" pattern="text" required>
                        <span class="form-error">
                            <strong>
                                {{ __('validation.required', ['attribute' => strtolower(__('system.last_name'))]) }}
                            </strong>
                        </span>
                    </div>
                    <div class="small-12 medium-4 cell">
                        <label class="text-right middle">{{ __('system.email') }}</label>
                    </div>
                    <div class="small-12 medium-8 cell">
                        <input type="email" :name="'attendees.' + index + '.email'" id="email" v-model="attendee.email"
                               pattern="email" required>
                        <span class="form-error">
                            <strong>
                                {{ __('validation.email', ['attribute' => strtolower(__('system.email'))]) }}
                            </strong>
                        </span>
                    </div>
                    <div class="small-12 medium-4 cell">
                        <label class="text-right middle">{{ __('system.type') }}</label>
                    </div>
                    <div class="small-12 medium-8 cell">
                        <label class="text-disabled">@{{ attendee.ticket.name }}</label>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <div class="spacer"></div>
</form>