@if (count($errors) > 0)
    <div role="alert" class="alert alert-warning" style="display: block;">
        <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ __('validation.errors_in_form') }}</p>
    </div>
@elseif (session('success'))
    <div role="alert" class="alert alert-success" style="display: block;">
        {!! session('success') !!}
    </div>
@elseif (session('alert'))
    <div role="alert" class="alert alert-warning" style="display: block;">
        <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {!! session('alert') !!}</p>
    </div>
@else
    <div role="alert" class="alert alert-warnng" style="display: none;">
        <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ __('validation.errors_in_form') }}</p>
    </div>
@endif