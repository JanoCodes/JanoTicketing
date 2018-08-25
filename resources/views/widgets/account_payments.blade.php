@if ($account->payments()->count() !== 0)
    <h3>{{ __('system.payments') }}</h3>
    <table>
        <thead>
        <tr>
            <th>{{ __('system.date_credited') }}</th>
            <th>{{ __('system.amount_paid') }}</th>
            <th>{{ __('system.method') }}</th>
            <th>{{ __('system.reference') }}</th>
        </tr>
        </thead>
        @foreach ($account->payments()->get() as $payment)
            <tr>
                <td>{{ $payment->made_at->toDateString() }}</td>
                <td>{{ $payment->full_amount }}</td>
                <td>{{ __('system.payment_methods.' . $payment->method) }}</td>
                <td>{{ $payment->reference }}</td>
            </tr>
        @endforeach
    </table>
@endif