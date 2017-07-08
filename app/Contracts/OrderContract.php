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

use Illuminate\Support\Collection;
use Jano\Models\User;

interface OrderContract
{
    /**
     * Create a new order instance.
     *
     * @param \Jano\Contracts\TicketContract $contract
     * @param \Jano\Models\User $user
     * @param \Illuminate\Support\Collection $tickets
     * @return \Jano\Models\Order
     */
    public function createTicketOrder(
        TicketContract $contract,
        User $user,
        Collection $tickets
    );
}
