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

namespace Jano\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validator;
use Jano\Contracts\ChargeContract;
use Jano\Contracts\TransferRequestContract;
use Jano\Models\TransferRequest;

class TransferRequestController extends Controller
{
    /**
     * @var \Jano\Contracts\TransferRequestContract
     */
    protected $request;

    /**
     * @var \Jano\Contracts\ChargeContract
     */
    protected $charge;

    /**
     * TicketRequestController constructor.
     *
     * @param \Jano\Contracts\TransferRequestContract
     * @param \Jano\Contracts\ChargeContract
     */
    public function __construct(TransferRequestContract $request, ChargeContract $charge)
    {
        $this->middleware(['auth']);
        $this->request = $request;
        $this->charge = $charge;
    }

    /**
     * Renders the edit transfer request page.
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
     * Get a validator for updating a transfer request instance.
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
     * Commit the updated transfer request instance.
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
        $transfer_request = $this->request->update($transfer_request, $request->all());

        return view('requests.update', [
            'transfer_request' => $transfer_request,
        ]);
    }
}
