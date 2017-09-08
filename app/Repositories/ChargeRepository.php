<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2017 Andrew Ying
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

namespace Jano\Repositories;

use Carbon\Carbon;
use Jano\Contracts\ChargeContract;
use Jano\Models\Account;
use Jano\Models\Charge;
use Jano\Settings\Facade as Setting;

class ChargeRepository implements ChargeContract
{
    /**
     * @inheritdoc
     */
    public function store(Account $account, $data)
    {
        $charge = new Charge();
        $charge->account()->associate($account);
        $charge->amount = $data['amount'];
        $charge->description = $data['description'];
        $charge->due_at = Carbon::now()->addDays(Setting::get('payment.deadline'));
        $charge->paid = false;
        $charge->save();

        return $charge;
    }

    /**
     * @inheritdoc
     */
    public function update(Charge $charge, $data)
    {
        $charge->description = $data['description'];

        if ($charge->paid && $data['amount'] > $charge->amount) {
            $charge->paid = false;
        }
        if (!$charge->paid) {
            $charge->due_by = Carbon::now()->addDays(Setting::get('payment.deadline'));
        }

        $charge->amount = $data['amount'];
        $charge->save();

        return $charge;
    }

    /**
     * @inheritdoc
     */
    public function markPaid(Charge $charge)
    {
        $charge->paid = true;
        $charge->due_by = null;
        $charge->save();

        return $charge;
    }

    /**
     * @inheritdoc
     */
    public function destroy(Charge $charge)
    {
        $charge->delete();
    }
}