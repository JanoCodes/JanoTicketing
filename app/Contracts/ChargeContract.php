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
use Jano\Models\Charge;

interface ChargeContract
{
    /**
     * Store a new charge instance.
     *
     * @param \Jano\Models\Account $account
     * @param array $data
     * @return \Jano\Models\Charge
     */
    public function store(Account $account, $data);

    /**
     * Update parameters of the charge instance.
     *
     * @param \Jano\Models\Charge $charge
     * @param array $data
     * @return \Jano\Models\Charge
     */
    public function update(Charge $charge, $data);

    /**
     * Mark charge as paid.
     *
     * @param \Jano\Models\Charge $charge
     * @return \Jano\Models\Charge
     */
    public function markPaid(Charge $charge);

    /**
     * Destroy the charge instance.
     *
     * @param \Jano\Models\Charge $charge
     * @return void
     */
    public function destroy(Charge $charge);
}