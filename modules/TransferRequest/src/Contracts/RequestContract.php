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

namespace Jano\Modules\TransferRequest\Contracts;

use Jano\Models\Attendee;
use Jano\Models\Charge;
use Jano\Modules\TransferRequest\Models\TransferRequest;

interface RequestContract
{
    /**
     * Store a new transfer request instance.
     *
     * @param \Jano\Models\Attendee $attendee
     * @param \Jano\Models\Charge $charge
     * @param array $data
     * @return \Jano\Modules\TransferRequest\Models\TransferRequest
     */
    public function store(Attendee $attendee, Charge $charge, $data);

    /**
     * Retrieve a collection of transfer requests.
     *
     * @param $query
     * @return \Illuminate\Support\Collection
     */
    public function search($query);

    /**
     * Update the parameters of the transfer request instance.
     *
     * @param \Jano\Modules\TransferRequest\Models\TransferRequest $request
     * @param array $data
     * @return \Jano\Modules\TransferRequest\Models\TransferRequest
     */
    public function update(TransferRequest $request, $data);

    /**
     * Mark the transfer request as confirmed.
     *
     * @param \Jano\Modules\TransferRequest\Models\TransferRequest $request
     * @return \Jano\Modules\TransferRequest\Models\TransferRequest
     */
    public function confirm(TransferRequest $request);

    /**
     * Return a collection of pending transfer request instances.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPending();

    /**
     * Mark the transfer request instance as processed.
     *
     * @param \Jano\Modules\TransferRequest\Models\TransferRequest $request
     * @return \Jano\Modules\TransferRequest\Models\TransferRequest
     */
    public function markAsProcessed(TransferRequest $request);

    /**
     * Destroy the transfer request instance.
     *
     * @param \Jano\Modules\TransferRequest\Models\TransferRequest $request
     * @return void
     */
    public function destroy(TransferRequest $request);
}