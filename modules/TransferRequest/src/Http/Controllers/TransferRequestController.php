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

namespace Jano\Modules\TransferRequest\Http\Controllers;

use Illuminate\Http\Request;
use Jano\Http\Controllers\Controller;
use Validator;
use Jano\Contracts\ChargeContract;
use Jano\Modules\TransferRequest\Contracts\RequestContract as TransferRequestContract;
use Jano\Modules\TransferRequest\Models\TransferRequest;

class TransferRequestController extends Controller
{
    /**
     * @var \Jano\Modules\TransferRequest\Contracts\RequestContract
     */
    protected $request;

    /**
     * @var \Jano\Contracts\ChargeContract
     */
    protected $charge;

    /**
     * TransferRequestController constructor.
     *
     * @param \Jano\Modules\TransferRequest\Contracts\RequestContract $request
     * @param \Jano\Contracts\ChargeContract $charge
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
     * @param \Jano\Modules\TransferRequest\Models\TransferRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(TransferRequest $request)
    {
        $this->authorize('update', $request);

        return view('transfer-request::edit', [
            'request' => $request,
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
     * @param \Jano\Modules\TransferRequest\Models\TransferRequest $transfer_request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, TransferRequest $transfer_request)
    {
        $this->authorize('update', $transfer_request);

        $this->updateValidator($request->all());
        $transfer_request = $this->request->update($transfer_request, $request->all());

        return view('transfer-request::update', [
            'request' => $transfer_request,
        ]);
    }
}
