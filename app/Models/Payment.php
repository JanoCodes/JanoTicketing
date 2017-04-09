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

namespace Jano\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * Create a new payment
     *
     * @param array $data
     * @return \Jano\Models\Payment
     */
    public static function create($data)
    {
        $payment = new self();
        $payment->order_id = $data['order_id'] ?? null;
        $payment->type = $data['type'];
        $payment->amount = $data['amount'];
        $payment->reference = $data['reference'];
        $payment->internal_reference = $data['internal_reference'] ?? null;
        $payment->made_at = $data['made_at'];
        $payment->save();
        
        return $payment;
    }

    /**
     * The order associated with the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('Jano\Models\Order');
    }
}
