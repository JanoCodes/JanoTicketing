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
use Jano\Contracts\TicketRequestContract;
use Jano\Models\Ticket;
use Jano\Models\TicketRequest;
use Validator;

class TicketRequestController extends Controller
{
    /**
     * @var \Jano\Contracts\TicketRequestContract
     */
    protected $contract;

    /**
     * TicketRequestController constructor.
     *
     * @param \Jano\Contracts\TicketRequestContract
     */
    public function __construct(TicketRequestContract $contract)
    {
        $this->middleware(['auth']);
        $this->contract = $contract;
    }

    /**
     * Render the create ticket request page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('requests.create');
    }

    /**
     * Get a validator for a newly created ticket request instance.
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
            'ticket' => 'required|sum_between:1,' . (Ticket::all()->count() + 1) / 2 . '|preferences',
            'ticket.*' => 'numeric',
        ]);
    }

    /**
     * Store the newly created ticket request instance.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', \Jano\Models\TicketRequest::class);

        $this->storeValidator($request->all());
        $ticket_request = $this->contract->store($request->user(), $request->all());

        return view('requests.store', [
            'ticket_request' => $ticket_request,
        ]);
    }

    /**
     * Renders the edit ticket request page.
     *
     * @param \Jano\Models\TicketRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(TicketRequest $request)
    {
        $this->authorize('update', $request);

        return view('requests.edit', [
            'ticket_request' => $request,
        ]);
    }

    /**
     * Get a validator for updating a ticket request instance.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function updateValidator($data)
    {
        return Validator::make($data, [
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'ticket' => 'required|sum_between:1,' . (Ticket::all()->count() + 1) / 2 . '|preferences',
            'ticket.*' => 'numeric',
        ]);
    }

    /**
     * Commit the updated ticket request instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Jano\Models\TicketRequest $ticket_request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, TicketRequest $ticket_request)
    {
        $this->authorize('update', $ticket_request);

        $this->updateValidator($request->all());
        $ticket_request = $this->contract->update($request->user(), $request->all());

        return view('requests.update', [
            'ticket_request' => $ticket_request,
        ]);
    }
}
