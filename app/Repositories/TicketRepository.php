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

use function array_push;
use Jano\Contracts\TicketContract;
use Jano\Models\Attendee;
use Jano\Models\Order;
use Jano\Models\Ticket;
use Jano\Models\User;
use Redis;

class TicketRepository implements TicketContract
{
    /**
     * @inheritdoc
     */
    public function hold(User $user, $request)
    {
        $tickets = Ticket::all();
        $reserved = array();
        $state = array();
        $ticket_unavailable = false;

        foreach ($user->toArray() as $attribute => $value) {
            $state->{camel_case($attribute)} = $value;
        }
        $state->attendees = array();

        foreach ($tickets as $ticket) {
            $status = $this->holdByType($ticket->id, $request['tickets'][$ticket->id]);
            $reserved[$ticket->id] = count($status);

            if ($status) {
                if (count($status) !== (int) $request['tickets'][$ticket->id]) {
                    $ticket_unavailable = true;
                }

                foreach ($status as $id) {
                    $attendee = new \stdClass();
                    foreach (Attendee::getAttributeListing() as $attribute) {
                        $attendee->{camel_case($attribute)} = '';
                    }
                    $attendee->ticket = $ticket->id;
                    $attendee->ticketId = $id;

                    $state->attendees[] = $attendee;
                }
            }
            else {
                $ticket_unavailable = true;
            }
        }

        return [
            'reserved' => $reserved,
            'state' => $state,
            'ticket_unavailable' => $ticket_unavailable
        ];
    }

    /**
     * @inheritdoc
     */
    public function reserve(Ticket $ticket, User $user, Order $order, $data)
    {
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
     * @return array|bool
     */
    private function holdByType($ticket_id, $number)
    {
        $options = [
            'cas' => true,
            'watch' => 'ticket:' . $ticket_id,
            'retry' => 3,
        ];
        $count = 0;
        $tickets = [];
        $time = time() + 15 * 60;

        Redis::transaction($options, function ($tx) use (&$ticket_id, &$number, &$count, &$tickets, &$time) {
            $tickets = $tx->zrangebyscore('ticket:' . $ticket_id, 0, time() - 1, 'LIMIT', 0, $number);
            $tx->multi();

            foreach ($tickets as $ticket) {
                $tx->zadd('ticket:' . $ticket_id, $time, $ticket);
            }

            $count++;
        });

        return $count > 0 ? $tickets : false;
    }
}