@if (count($errors) > 0)
    <div data-abide-error role="alert" class="alert callout" style="display: block;">
        <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ __('validation.errors_in_form') }}</p>
    </div>
@elseif (isset($alert))
    <div data-abide-error role="alert" class="alert callout" style="display: block;">
        <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {!! $alert !!}</p>
    </div>
@else
    <div data-abide-error class="alert callout" style="display: none;">
        <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ __('validation.errors_in_form') }}</p>
    </div>
@endif