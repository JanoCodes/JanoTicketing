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

namespace Jano\Modules\TicketRequest\Contracts;

use Jano\Models\Attendee;
use Jano\Modules\TicketRequest\Models\TicketRequest;
use Jano\Models\User;

interface RequestContract
{
    /**
     * Store a new ticket request instance.
     *
     * @param \Jano\Models\User $user
     * @param $data
     * @return \Jano\Modules\TicketRequest\Models\TicketRequest
     */
    public function store(User $user, $data);

    /**
     * Retrieve a collection of ticket requests.
     *
     * @param $query
     * @return \Illuminate\Support\Collection
     */
    public function search($query);

    /**
     * Update the parameters of the ticket request instance.
     *
     * @param \Jano\Modules\TicketRequest\Models\TicketRequest $request
     * @param array $data
     * @return \Jano\Modules\TicketRequest\Models\TicketRequest
     */
    public function update(TicketRequest $request, $data);

    /**
     * Retrieve a collection of pending ticket requests.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPending();

    /**
     * Mark the ticket request instance as honoured.
     *
     * @param \Jano\Modules\TicketRequest\Models\TicketRequest $request
     * @param \Jano\Models\Attendee $attendee
     * @return \Jano\Modules\TicketRequest\Models\TicketRequest
     */
    public function markAsHonoured(TicketRequest $request, Attendee $attendee);

    /**
     * Destroy the ticket request instance.
     *
     * @param \Jano\Modules\TicketRequest\Models\TicketRequest $request
     */
    public function destroy(TicketRequest $request);
}