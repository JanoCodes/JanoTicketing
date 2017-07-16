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
use Jano\Models\Attendee;
use Validator;

class AttendeeController extends Controller
{
    /**
     * @var \Jano\Contracts\TransferRequestContract
     */
    protected $transfer_contract;

    /**
     * AttendeeController constructor.
     *
     * @param \Jano\Contracts\TransferRequestContract $transfer_contract
     */
    public function __construct(TransferRequestContract $transfer_contract)
    {
        $this->middleware(['auth']);
        $this->transfer_contract = $transfer_contract;
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
    protected function validator($data)
    {
        return Validator::make($data, [
            'title' => 'required',
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

        $this->validator($request->all());
        $this->transfer_contract->store($attendee, $request->all());

        return redirect('/');
    }
}
