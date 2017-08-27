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
use Jano\Contracts\TransferRequestContract;
use Jano\Models\TransferRequest;

class ConfirmedTransferRequestController extends Controller
{
    /**
     * @var \Jano\Contracts\TransferRequestContract
     */
    protected $contract;

    /**
     * ConfirmedTransferRequestController constructor.
     *
     * @param \Jano\Contracts\TransferRequestContract $contract
     */
    public function __construct(TransferRequestContract $contract)
    {
        $this->middleware(['auth']);
        $this->contract = $contract;
    }

    /**
     * Confirm the transfer request.
     *
     * @param \Jano\Models\TransferRequest $transfer
     * @param string $token
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(TransferRequest $transfer, $token)
    {
        $this->authorize('update', $transfer);

        if ($transfer->confirmation_code !== $token) {
            throw new AuthorizationException('The confirmation code provided is invalid.');
        }

        $this->contract->confirm($transfer);

        return redirect('/');
    }

    /**
     * Associate the transfer request with the new user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Jano\Models\TransferRequest $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransferRequest $transfer)
    {
        try {
            $this->authorize('associate', $transfer);
        } catch (AuthorizationException $e) {
            return view('transfer.associate_unauthorised');
        }

        $this->contract->update($transfer, ['user_id' => $request->user()]);

        return view('transfer.associate');
    }
}
