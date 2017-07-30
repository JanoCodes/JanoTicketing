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

use DB;
use Jano\Contracts\TicketContract;
use Jano\Models\Attendee;
use Jano\Models\Order;
use Jano\Models\Ticket;
use Jano\Models\User;
use stdClass;

class TicketRepository implements TicketContract
{
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

        foreach ($tickets as $ticket) {
            $status = $this->holdByType(
                $ticket->id,
                $request['tickets'][$ticket->id],
                $time
            );
            $reserved[$ticket->id] = count($status);

            if ($status) {
                if (count($status) !== (int) $request['tickets'][$ticket->id]) {
                    $ticket_unavailable = true;
                }

                foreach ($status as $id) {
                    $attendee = new \stdClass();
                    foreach (Attendee::getAttributeListing() as $attribute) {
                        $attendee->{$attribute} = '';
                    }
                    $attendee->ticket = $ticket;
                    $attendee->ticket_id = $id;

                    $state->attendees[] = $attendee;
                }
            } else {
                $ticket_unavailable = true;
            }
        }

        return [
            'reserved' => $reserved,
            'time' => $time,
            'state' => $state,
            'ticket_unavailable' => $ticket_unavailable
        ];
    }

    /**
     * @inheritdoc
     */
    public function reserve(Ticket $ticket, User $user, $data)
    {
        DB::beginTransaction();

        $attendee = new Attendee();
        $attendee->title = $data['title'];
        $attendee->first_name = $data['first_name'];
        $attendee->last_name = $data['last_name'];
        $attendee->email = $data['email'];
        $attendee->user()->associate($user);
        $attendee->primary_ticket_holder = $data['primary_ticket_holder'];
        $attendee->ticket()->associate($ticket);
        $attendee->checked_in = false;
        $order->attendees()->save($attendee);

        DB::table('ticket_store')->where('id', $data['ticket_id'])->delete();
        DB::commit();

        return $attendee;
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
     * @return array|bool
     */
    private function holdByType($ticket_id, $number, $time)
    {
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

        return count($tickets) > 0 ? $tickets : false;
    }
}
