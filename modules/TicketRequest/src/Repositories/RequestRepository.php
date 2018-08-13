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

namespace Jano\Modules\TicketRequest\Repositories;

use Carbon\Carbon;
use Jano\Models\Attendee;
use Jano\Models\User;
use Jano\Modules\TicketRequest\Contracts\RequestContract;
use Jano\Modules\TicketRequest\Events\TicketRequestCreated;
use Jano\Modules\TicketRequest\Models\TicketRequest;
use Jano\Modules\TicketRequest\Notifications\TicketRequestCreated as TicketRequestCreatedNotification;

class RequestRepository implements RequestContract
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
        $request->honoured = false;
        $request->save();

        $user->notify(new TicketRequestCreatedNotification($request));
        event(new TicketRequestCreated($user, $request));

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function search($query)
    {
        $query = $query ? '%' . $query . '%' : '%';

        return TicketRequest::where('first_name', 'like', $query)
            ->orWhere('last_name', 'like', $query)
            ->orWhere('email', 'like', $query)
            ->withTrashed()
            ->paginate();
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
    public function getPending()
    {
        return TicketRequest::where('honoured', false)->all();
    }

    /**
     * @inheritdoc
     */
    public function markAsHonoured(TicketRequest $request, Attendee $attendee)
    {
        $request->attendee()->associate($attendee);
        $request->honoured = true;
        $request->honoured_at = Carbon::now();
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
