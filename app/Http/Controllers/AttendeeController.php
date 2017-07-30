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

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use function implode;
use Jano\Contracts\AttendeeContract;
use Jano\Contracts\TicketContract;
use Jano\Contracts\TransferRequestContract;
use Jano\Contracts\UserContract;
use Jano\Models\Attendee;
use Validator;

class AttendeeController extends Controller
{
    /**
     * @var \Jano\Contracts\UserContract
     */
    protected $user;

    /**
     * @var \Jano\Contracts\TicketContract
     */
    protected $ticket;

    /**
     * @var \Jano\Contracts\AttendeeContract
     */
    protected $attendee;

    /**
     * @var \Jano\Contracts\TransferRequestContract
     */
    protected $transfer;

    /**
     * AttendeeController constructor.
     *
     * @param \Jano\Contracts\UserContract $user
     * @param \Jano\Contracts\TicketContract $ticket
     * @param \Jano\Contracts\AttendeeContract $attendee
     * @param \Jano\Contracts\TransferRequestContract $transfer
     */
    public function __construct(
        UserContract $user,
        TicketContract $ticket,
        AttendeeContract $attendee,
        TransferRequestContract $transfer
    ) {
        $this->middleware(['auth']);
        $this->user = $user;
        $this->ticket = $ticket;
        $this->attendee = $attendee;
        $this->transfer = $transfer;
    }

    /**
     * Render the create order page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \RuntimeException
     */
    public function create(Request $request)
    {
        $this->authorize('create', \Jano\Models\Attendee::class);

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

        return view('attendees.create', [
            'tickets' => Ticket::all(),
            'reserved' => $result['reserved'],
            'time' => $result['time'],
            'state' => $result['state']
        ]);
    }

    /**
     * Get a validator for newly created attendees.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function storeValidator($data)
    {
        return Validator::make($data, [
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
    }

    /**
     * Store the attendees.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', \Jano\Models\Attendee::class);

        $this->storeValidator($request->input());

        $user = $request->user();
        $this->user->update($user, $request->only([
            'title',
            'first_name',
            'last_name',
            'email',
            'phone'
        ]));
        $attendees = $this->attendee->store(
            $this->ticket,
            $user,
            collect($request->input('attendees'))
        );

        return $attendees;
    }

    /**
     * Render the create ticket transfer request page.
     *
     * @param \Jano\Models\Attendee $attendee
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Attendee $attendee)
    {
        $this->authorize('update', $attendee);

        return view('transfers.create', [
            'attendee' => $attendee
        ]);
    }

    /**
     * Get a validator for a newly created ticket transfer request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function updateValidator($data)
    {
        return Validator::make($data, [
            'title' => 'required|in:' . implode(',', __('system.titles')),
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        ]);
    }

    /**
     * Store a newly created ticket transfer request instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Jano\Models\Attendee $attendee
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Attendee $attendee)
    {
        $this->authorize('update', $attendee);

        $this->updateValidator($request->all());
        $this->transfer->store($attendee, $request->all());

        return redirect('/');
    }

    /**
     * Destroy the attendee instance.
     *
     * @param \Jano\Models\Attendee $attendee
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destory(Attendee $attendee)
    {
        $this->authorize('destroy', $attendee);
        $this->attendee->destroy($attendee);
    }
}
