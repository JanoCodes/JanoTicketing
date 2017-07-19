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

namespace Jano\Http\Controllers;

use Illuminate\Http\Request;
use Jano\Contracts\OrderContract;
use Jano\Contracts\TicketContract;
use Jano\Facades\Helper;
use Jano\Models\Order;
use Jano\Models\Ticket;
use Jano\Repositories\TicketRepository;

class OrderController extends Controller
{

    /**
     * The TicketContract instance.
     *
     * @var \Jano\Contracts\TicketContract
     */
    protected $ticket;

    /**
     * The OrderContract instance.
     *
     * @var \Jano\Contracts\OrderContract
     */
    protected $order;

    /**
     * OrderController constructor.
     *
     * @param \Jano\Contracts\TicketContract $ticket
     * @param \Jano\Contracts\OrderContract $order
     */
    public function __construct(TicketContract $ticket, OrderContract $order)
    {
        $this->middleware(['auth']);
        $this->ticket = $ticket;
        $this->order = $order;
    }

    /**
     * Render the create order page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        $this->authorize('create', \Jano\Models\Order::class);

        $user = $request->user();
        $this->validate($request, [
            'tickets.*' => 'required|numeric|min:0',
            'tickets' => 'sum_between:1,' . $user->ticket_limit
        ]);

        $result = $this->ticket->hold($user, $request->all());

        if (array_sum($result['reserved']) === 0) {
            return redirect(route('event.list'))->with('alert', '<strong>'
                . __('system.tickets_unavailable_title') . '</strong><br />'
                . __('system.tickets_unavailable_message'));
        }
        if ($result['ticket_unavailable']) {
            $request->session()->flash('alert', '<strong>'
                . __('system.tickets_partly_unavailable_title') . '</strong><br />'
                . __('system.tickets_partly_unavailable_message'));
        }

        return view('orders.create', [
            'tickets' => Ticket::all(),
            'reserved' => $result['reserved'],
            'time' => $result['time'],
            'state' => $result['state']
        ]);
    }

    /**
     * Store the ticket order.
     *
     * @param Request $request
     * @return \Jano\Models\Order
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', \Jano\Models\Order::class);

        $this->validate($request, [
            'title' => 'required|in:' . implode(',', __('system.titles')),
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|phone:GB',
            'attendees.*.title' => 'required',
            'attendees.*.first_name' => 'required',
            'attendees.*.last_name' => 'required',
            'attendees.*.email' => 'required|email',
            'attendees.*.ticket' => 'required|exists:tickets,id',
            'attendees.*.primary_ticket_holder' => 'sum_between:1,1'
        ]);

        $order = $this->order->createTicketOrder(
            $this->ticket,
            $request->user(),
            collect($request->input('attendees'))
        );

        return $order::with('attendees');
    }
}