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
use Jano\Contracts\ChargeContract;
use Jano\Http\Controllers\Controller;
use Jano\Models\Attendee;
use Jano\Modules\TransferRequest\Contracts\RequestContract;

class AttendeeController extends Controller
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
    public function __construct(RequestContract $request, ChargeContract $charge)
    {
        $this->middleware(['auth']);
        $this->request = $request;
        $this->charge = $charge;
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

        return view('transfer-request::create', [
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
     * Store the ticket transfer request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Jano\Models\Attendee $attendee
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Attendee $attendee)
    {
        $this->authorize('update', $attendee);
        $user = $attendee->user();

        $this->updateValidator($request->all());
        $charge = $this->charge->store($user->account()->first(), [

        ]);

        $transfer_request = $this->request->store($attendee, $charge, $request->only([
            'title',
            'first_name',
            'last_name',
            'email'
        ]));

        return view('transfer-request::store', [
            'transfer_request' => $transfer_request
        ]);
    }
}