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

use Jano\Contracts\TicketRequestContract;
use Jano\Models\TicketRequest;
use Jano\Models\User;

class TicketRequestRepository implements TicketRequestContract
{
    /**
     * @inheritdoc
     */
    public function store(User $user, $data)
    {
        $request = new TicketRequest();
        $request->user()->associate($user);
        $request->title = $data['title'];
        $request->first_name = $data['first_name'];
        $request->last_name = $data['last_name'];
        $request->email = $data['email'];
        $request->ticket_preference = $data['ticket'];
        $request->right_to_buy = $user->right_to_buy > 0;
        $request->status = 0;
        $request->save();

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function update(TicketRequest $request, $data)
    {
        $request->title = $data['title'];
        $request->first_name = $data['first_name'];
        $request->last_name = $data['last_name'];
        $request->email = $data['email'];
        $request->ticket_preference = $data['ticket'];
        $request->save();

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function destroy(TicketRequest $request)
    {
        $request->delete();
    }
}
