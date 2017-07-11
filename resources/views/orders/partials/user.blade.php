<form id="form" data-abide novalidate>
    <div class="grid-x grid-padding-x" id="child">
        <div class="small-12 medium-4 cell">
            <label class="text-right middle">{{ __('system.title') }}</label>
        </div>
        <div class="small-12 medium-8 cell">
            <select name="title" id="title" v-model="title" required>
                @foreach (__('system.titles') as $title)
                    <option value="{{ $title }}">{{ $title }}</option>
                @endforeach
            </select>
        </div>
        <div class="small-12 medium-4 cell">
            <label class="text-right middle">{{ __('system.first_name') }}</label>
        </div>
        <div class="small-12 medium-8 cell">
            <input type="text" name="first_name" id="first_name" v-model="first_name" pattern="text"
                   required>
            <span class="form-error">
                <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.first_name'))]) }}</strong>
            </span>
        </div>
        <div class="small-12 medium-4 cell">
            <label class="text-right middle">{{ __('system.last_name') }}</label>
        </div>
        <div class="small-12 medium-8 cell">
            <input type="text" name="last_name" id="last_name" v-model="last_name" pattern="text"
                   required>
            <span class="form-error">
                <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.last_name'))]) }}</strong>
            </span>
        </div>
        <div class="small-12 medium-4 cell">
            <label class="text-right middle">{{ __('system.email') }}</label>
        </div>
        <div class="small-12 medium-8 cell">
            <input type="email" name="email" id="email" v-model="email" pattern="email" required>
            <span class="form-error">
                <strong>{{ __('validation.email', ['attribute' => strtolower(__('system.email'))]) }}</strong>
            </span>
        </div>
        <div class="small-12 medium-4 cell">
            <label class="text-right middle">{{ __('system.phone') }}</label>
        </div>
        <div class="small-12 medium-8 cell">
            <input type="text" name="phone" id="phone" v-model="phone" required>
            <span class="form-error">
                <strong>{{ __('validation.required', ['attribute' => strtolower(__('system.phone'))]) }}</strong>
            </span>
        </div>
    </div>
</form>