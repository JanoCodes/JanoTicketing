<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2017 Andrew Ying
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v3.0 as
 * published by the Free Software Foundation.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Jano\Contracts;

use Jano\Models\Account;
use Jano\Models\Payment;

interface PaymentContract
{
    /**
     * Store a new payment instance.
     *
     * @param array $data
     * @param \Jano\Models\Account|null $account
     * @return \Jano\Models\Payment
     */
    public function store($data, Account $account = null);

    /**
     * Associate the payment instance with a specific account.
     *
     * @param \Jano\Models\Payment $payment
     * @param \Jano\Models\Account $account
     * @return \Jano\Models\Payment
     */
    public function associate(Payment $payment, Account $account);

    /**
     * Retrieve a collection of payments.
     *
     * @param $query
     * @return \Illuminate\Support\Collection
     */
    public function search($query);

    /**
     * Destroy the payment instance.
     *
     * @param \Jano\Models\Payment $payment
     */
    public function destroy(Payment $payment);
}
