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
use Illuminate\Support\Collection;
use Jano\Contracts\OrderContract;
use Jano\Contracts\TicketContract;
use Jano\Events\TicketOrderCreated;
use Jano\Models\Order;
use Jano\Models\Ticket;
use Jano\Models\User;
use Setting;

class OrderRepository implements OrderContract
{
    /**
     * @inheritdoc
     */
    public function createTicketOrder(
        TicketContract $contract,
        User $user,
        Collection $attendees
    ) {
        $tickets = Ticket::all();

        $amount = 0;

        foreach ($tickets as $ticket) {
            $amount += $contract->getPrice($ticket, $user) *
                $attendees->where('ticket_id', $ticket['id'])->count();
        }

        $order = new Order();
        $order->user()->associate($user);
        $order->type = Order::TYPE_TICKET;
        $order->amount_due = $amount;
        $order->amount_paid = 0;
        $order->paid = false;
        $order->payment_due_at = Carbon::now()
            ->addDays(Setting::get('payment.deadline'));
        $order->save();

        foreach ($attendees as $attendee) {
            $ticket = $tickets->where('id', $attendee['ticket_id'])->first();
            $contract->reserve($ticket, $user, $order, $attendee);
        }

        event(new TicketOrderCreated($user, $order));

        return $order;
    }
}
