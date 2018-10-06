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

namespace Jano\Repositories;

use Hashids\Hashids;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Jano\Contracts\TicketContract;
use Jano\Models\Attendee;
use Jano\Models\Ticket;
use Jano\Models\User;
use stdClass;

class TicketRepository implements TicketContract
{
    /**
     * @inheritdoc
     */
    public function store($data)
    {
        $ticket = new Ticket();
        $ticket->name = $data['name'];
        $ticket->price = $data['amount'];
        $ticket->save();

        return $ticket;
    }

    /**
     * @inheritdoc
     */
    public function search($query)
    {
        $query = $query ? '%' . $query . '%' : '%';

        return Ticket::where('name', 'like', $query)->paginate();
    }

    /**
     * @inheritdoc
     */
    public function update(Ticket $ticket, $data)
    {
        foreach ($data as $attribute => $value) {
            $ticket->{$attribute} = $value;
        }
        $ticket->save();

        return $ticket;
    }

    /**
     * @inheritdoc
     */
    public function hold(User $user, $request)
    {
        $tickets = Ticket::all();
        $reserved = array();
        $state = new stdClass();
        $ticket_unavailable = false;
        $time = time();

        foreach ($user->toArray() as $attribute => $value) {
            $state->{$attribute} = $value;
        }
        $state->attendees = array();
        $state->has_attendees = $user->attendees()->count() !== 0;

        foreach ($tickets as $ticket) {
            if ($request['tickets'][$ticket->id]) {
                $status = $this->holdByType(
                    $ticket->id,
                    $request['tickets'][$ticket->id],
                    $time
                );
                $reserved[$ticket->id] = $status ? count($status): 0;

                if ($status) {
                    if ($status->count() !== (int) $request['tickets'][$ticket->id]) {
                        $ticket_unavailable = true;
                    }

                    foreach ($status as $item) {
                        $attendee = new \stdClass();
                        foreach (Attendee::getAttributeListing() as $attribute) {
                            $attendee->{$attribute} = '';
                        }
                        $attendee->ticket = $ticket;
                        $attendee->ticket_id = $item->id;
                        $attendee->user_ticket_price = HelperRepository::getUserPrice(
                            $ticket->price,
                            $user,
                            false
                        );
                        $attendee->full_user_ticket_price = HelperRepository::getUserPrice(
                            $ticket->price,
                            $user
                        );

                        $state->attendees[] = $attendee;
                    }
                } else {
                    $ticket_unavailable = true;
                }
            }
        }

        return [
            'reserved' => $reserved,
            'time' => $time + 60 * 15,
            'state' => $state,
            'ticket_unavailable' => $ticket_unavailable
        ];
    }

    /**
     * @inheritdoc
     */
    public function reserve($data, $frontend)
    {
        $hashids = new Hashids(config('app.key'), 6);

        $attendee = new Attendee();
        $attendee->title = $data['data']['title'];
        $attendee->first_name = $data['data']['first_name'];
        $attendee->last_name = $data['data']['last_name'];
        $attendee->email = $data['data']['email'];
        $attendee->user()->associate($data['user']);
        $attendee->charge()->associate($data['charge']);
        $attendee->primary_ticket_holder = $data['data']['primary_ticket_holder'] ?? false;
        $attendee->ticket()->associate($data['ticket']);
        $attendee->uuid = $hashids->encode((int) $data['data']['ticket_id']);
        $attendee->checked_in = false;
        $attendee->save();

        if ($frontend) {
            DB::table('ticket_store')->where('id', $data['data']['ticket_id'])->delete();
        }

        return $attendee;
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function destroy(Ticket $ticket)
    {
        if ($ticket->attendees()) {
            throw new InvalidArgumentException('Attendees with this ticket class exist. Cannot delete
                ticket class.');
        }

        $ticket->delete();
    }

    /**
     * @inheritdoc
     */
    public function getPrice(Ticket $ticket, User $user)
    {
        return $ticket->price + $user->surcharge;
    }

    /**
     * Hold tickets of a specific ticket type
     *
     * @param int $ticket_id
     * @param int $number
     * @param int $time
     * @return mixed
     */
    private function holdByType($ticket_id, $number, $time)
    {
        if ($number == 0) {
            return false;
        }

        DB::beginTransaction();

        $tickets = DB::table('ticket_store')
            ->select('id')
            ->where('ticket_id', $ticket_id)
            ->where('reserved_time', '<', $time - 1)
            ->take($number)
            ->lockForUpdate()
            ->get();

        foreach ($tickets as $ticket) {
            DB::table('ticket_store')
                ->where('id', $ticket->id)
                ->update(['reserved_time' => $time + 60 * 15]);
        }

        DB::commit();

        return $tickets->count() > 0 ? $tickets : false;
    }
}
