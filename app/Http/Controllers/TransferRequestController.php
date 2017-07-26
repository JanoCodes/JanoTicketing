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
use Jano\Contracts\TransferRequestContract;
use Jano\Models\TransferRequest;
use Validator;

class TransferRequestController extends Controller
{
    /**
     * @var \Jano\Contracts\TransferRequestContract
     */
    protected $contract;

    /**
     * TicketRequestController constructor.
     *
     * @param \Jano\Contracts\TransferRequestContract
     */
    public function __construct(TransferRequestContract $contract)
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
        return view('transfers.create');
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
        $transfer_request = $this->contract->store($request->user(), $request->all());

        return view('transfer.store', [
            'transfer_store' => $transfer_request,
        ]);
    }

    /**
     * Renders the edit ticket request page.
     *
     * @param \Jano\Models\TransferRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(TransferRequest $request)
    {
        $this->authorize('update', $request);

        return view('requests.edit', [
            'transfer_request' => $request,
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
        ]);
    }

    /**
     * Commit the updated ticket request instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Jano\Models\TransferRequest $transfer_request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, TransferRequest $transfer_request)
    {
        $this->authorize('update', $transfer_request);

        $this->updateValidator($request->all());
        $transfer_request = $this->contract->update($transfer_request, $request->all());

        return view('requests.update', [
            'transfer_request' => $transfer_request,
        ]);
    }
}
