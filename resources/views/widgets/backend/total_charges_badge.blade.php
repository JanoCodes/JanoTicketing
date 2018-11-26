<div class="card-body backend-card">
    <small>
        <i class="fas fa-credit-card fa-fw" aria-hidden="true"></i> {{ __('system.total_charges') }}
    </small>
    <h2>{{ Setting::get('payment.currency') }}{{ $charges_total }}</h2>
</div>