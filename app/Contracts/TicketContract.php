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

namespace Jano\Contracts;

use Jano\Models\Charge;
use Jano\Models\Ticket;
use Jano\Models\User;

interface TicketContract
{
    /**
     * Hold tickets for the user.
     *
     * @param \Jano\Models\User $user
     * @param array $request
     * @return array
     */
    public function hold(User $user, $request);

    /**
     * Reserve a ticket for the user.
     *
     * @param array $data
     * @param boolean $frontend
     * @return \Jano\Models\Attendee
     */
    public function reserve($data, $frontend);

    /**
     * Get ticket price.
     *
     * @param Ticket $ticket
     * @param User $user
     * @return float
     */
    public function getPrice(Ticket $ticket, User $user);
}
