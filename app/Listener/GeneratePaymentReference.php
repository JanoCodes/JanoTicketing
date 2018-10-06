<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2018 Andrew Ying
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v3.0 as
 * published by the Free Software Foundation. You must preserve all legal
 * notices and author attributions present.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Jano\Listener;

use Hashids\Hashids;
use Jano\Events\AccountSaving;

class GeneratePaymentReference
{
    /**
     * @param \Jano\Events\AccountSaving $event
     */
    public function handle(AccountSaving $event)
    {
        $user = $event->account->user()->first();
        $hashids = new Hashids(config('app.key'), 5);

        $payment_reference = str_pad(substr($user->last_name, 0, 6), 6, '0');
        $payment_reference .= $user->first_name[0];
        $payment_reference .= substr($hashids->encode($event->account->id), 0, 5);
        $payment_reference = strtoupper($payment_reference);

        $event->account->payment_reference = $payment_reference;
    }
}