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

use Jano\Contracts\TransferRequestContract;
use Jano\Models\Attendee;
use Jano\Models\TransferRequest;

class TransferRequestRepository implements TransferRequestContract
{
    /**
     * @inheritdoc
     */
    public function store(Attendee $attendee, $data)
    {
        $request = new TransferRequest();
        $request->user()->associate($attendee->user());
        $request->attendee()->associate($attendee);
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
     */
    public function update(TransferRequest $request, $data)
    {
        $request->title = $data['title'];
        $request->first_name = $data['first_name'];
        $request->last_name = $data['last_name'];
        $request->email = $data['email'];
        $request->save();

        return $request;
    }
}