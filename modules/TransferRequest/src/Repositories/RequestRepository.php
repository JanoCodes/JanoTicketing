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

namespace Jano\Modules\TransferRequest\Repositories;

use Carbon\Carbon;
use InvalidArgumentException;
use Jano\Modules\TransferRequest\Events\TransferRequestCreated;
use Jano\Modules\TransferRequest\Events\TransferRequestProcessed;
use Jano\Models\Attendee;
use Jano\Models\Charge;
use Jano\Modules\TransferRequest\Models\TransferRequest;
use Jano\Models\User;
use Jano\Modules\TransferRequest\Contracts\RequestContract;
use Jano\Modules\TransferRequest\Notifications\TransferRequestCreated as TransferRequestCreatedNotification;
use Jano\Modules\TransferRequest\Notifications\TransferRequestProcessed as TransferRequestProcessedNotification;

class RequestRepository implements RequestContract
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
        $request->confirmed = false;
        $request->confirmation_code = str_random();
        $request->processed = false;
        $request->save();

        $attendee->user()->notify(new TransferRequestCreatedNotification($charge->account(), $request));
        event(new TransferRequestCreated($attendee->user(), $request));

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function search($query)
    {
        $query = $query ? '%' . $query . '%' : '%';

        return TransferRequest::where('old_first_name', 'like', $query)
            ->orWhere('old_last_name', 'like', $query)
            ->orWhere('old_email', 'like', $query)
            ->orWhere('first_name', 'like', $query)
            ->orWhere('last_name', 'like', $query)
            ->orWhere('email', 'like', $query)
            ->withTrashed()
            ->paginate();
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
     * @throws \InvalidArgumentException
     */
    public function confirm(TransferRequest $request)
    {
        if ($request->processed) {
            throw new InvalidArgumentException('A processed transfer request cannot be updated.');
        }

        $request->confirmed = true;
        $request->confirmation_code = null;
        $request->save();
    }

    /**
     * @inheritdoc
     */
    public function getPending()
    {
        return TransferRequest::where(function ($query) {
            return $query->where('processed', false)
                ->where('primary_ticket_holder', false)
                ->whereHas('charge', function ($query) {
                    $query->where('paid', true);
                });
        })->orWhere(function ($query) {
            return $query->where('processed', false)
                ->where('primary_ticket_holder', true)
                ->whereHas('new_user')
                ->whereHas('charge', function ($query) {
                    return $query->where('paid', true);
                });
        })->all();
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function associateNewUser(TransferRequest $request, User $user)
    {
        if ($request->processed) {
            throw new InvalidArgumentException('A new user cannot be associated with a processed transfer '
                . 'request.');
        }

        $request->newUser()->associate($user);
        $request->save();

        return $request;
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function markAsProcessed(TransferRequest $request)
    {
        if ($request->processed) {
            throw new InvalidArgumentException('The transfer request has already been processed.');
        }

        $request->processed = true;
        $request->processed_at = Carbon::now();
        $request->save();

        $request->user()->notify(new TransferRequestProcessedNotification($request));
        event(new TransferRequestProcessed($request->user(), $request));

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function destroy(TransferRequest $request)
    {
        if (!$request || $request->processed) {
            throw new InvalidArgumentException('The transfer request selected is invalid.');
        }

        $request->delete();
    }
}