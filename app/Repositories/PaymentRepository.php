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

namespace Jano\Repositories;

use Jano\Contracts\PaymentContract;
use Jano\Models\Order;
use Jano\Models\Payment;

class PaymentRepository implements PaymentContract
{
    /**
     * @inheritdoc
     */
    public function store($data, Order $order = null)
    {
        $payment = new Payment();

        if ($order) {
            $payment->order()->associate($order);
        }

        $payment->amount = $data['amount'];
        $payment->type = $data['type'];
        $payment->reference = $data['reference'];
        $payment->internal_reference = $data['internal_reference'] ?? null;
        $payment->made_at = $data['made_at'];
        $payment->save();

        return $payment;
    }

    /**
     * @inheritdoc
     */
    public function associate(Payment $payment, Order $order)
    {
        $payment->order()->associate($order);
        $payment->save();

        return $payment;
    }

    /**
     * @inheritdoc
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
    }
}