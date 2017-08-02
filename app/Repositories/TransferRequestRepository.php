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

use Carbon\Carbon;
use InvalidArgumentException;
use Jano\Contracts\TransferRequestContract;
use Jano\Events\TransferRequestProcessed;
use Jano\Models\Attendee;
use Jano\Models\Charge;
use Jano\Models\TransferRequest;

class TransferRequestRepository implements TransferRequestContract
{
    /**
     * @inheritdoc
     */
    public function store(Attendee $attendee, Charge $charge, $data)
    {
        $request = new TransferRequest();
        $request->user()->associate($attendee->user());
        $request->attendee()->associate($attendee);
        $request->charge()->associate($charge);
        $request->old_title = $attendee->title;
        $request->old_first_name = $attendee->first_name;
        $request->old_last_name = $attendee->last_name;
        $request->old_email = $attendee->email;
        $request->title = $data['title'];
        $request->first_name = $data['first_name'];
        $request->last_name = $data['last_name'];
        $request->email = $data['email'];
        $request->primary_ticket_holder = $attendee->primary_ticket_holder;
        $request->processed = false;
        $request->save();

        return $request;
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function update(TransferRequest $request, $data)
    {
        if ($request->processed) {
            throw new InvalidArgumentException('A processed transfer request cannot be updated.');
        }

        $request->title = $data['title'];
        $request->first_name = $data['first_name'];
        $request->last_name = $data['last_name'];
        $request->email = $data['email'];
        $request->save();

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function getPending()
    {
        return TransferRequest::where('processed', false)
            ->whereHas('charge', function ($query) {
                $query->where('paid', true);
            })->all();
    }

    public function associateNew(TransferRequest $request, Attendee $attendee)
    {
        if ($request->processed) {
            throw new InvalidArgumentException('A new attendee cannot be associated with a processed transfer '
                . 'request.');
        }

        $request->newAttendee()->associate($attendee);
        $request->save();

        return $request;
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function process(TransferRequest $request)
    {
        if ($request->processed) {
            throw new InvalidArgumentException('The transfer request has already been processed.');
        }

        $request->processed = true;
        $request->processed_at = Carbon::now();
        $request->save();

        event(new TransferRequestProcessed($request->user(), $request));

        return $request;
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function destroy(TransferRequest $request)
    {
        if ($request->processed) {
            throw new InvalidArgumentException('The transfer request has already been processed.');
        }

        $request->delete();
    }
}