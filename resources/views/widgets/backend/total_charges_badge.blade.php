<small>
    <i class="fas fa-credit-card fa-fw" aria-hidden="true"></i> {{ __('system.total_charges') }}
</small>
<div class="stat">{{ Setting::get('payment.currency') }}{{ $charges_total }}</div>