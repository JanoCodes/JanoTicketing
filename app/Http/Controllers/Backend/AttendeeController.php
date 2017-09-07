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

namespace Jano\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validator;
use Jano\Contracts\AttendeeContract;
use Jano\Http\Controllers\Controller;
use Jano\Http\Traits\RendersAjaxView;
use Jano\Models\Attendee;
use Jano\Models\User;

class AttendeeController extends Controller
{
    use RendersAjaxView;

    /**
     * @var \Jano\Contracts\AttendeeContract
     */
    protected $contract;

    /**
     * AttendeeController constructor.
     *
     * @param \Jano\Contracts\AttendeeContract $contract
     */
    public function __construct(AttendeeContract $contract)
    {
        $this->middleware(['auth', 'staff']);
        $this->contract = $contract;
    }

    /**
     * Render an index of all attendees.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->ajaxView(
            $request,
            'backend.attendees.index',
            $this->contract->search($request->get('q'))
        );
    }

    /**
     * Renders the attendee creation page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.attendees.create');
    }

    /**
     * Return the validator instance.
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function storeValidator($data)
    {
        return Validator::make($data, [
            'user' => 'required|exists:users,id',
            'attendees.*.title' => 'required',
            'attendees.*.first_name' => 'required',
            'attendees.*.last_name' => 'required',
            'attendees.*.email' => 'required|email',
            'attendees.*.ticket' => 'required|exists:tickets,id',
        ]);
    }

    /**
     * Store the newly created attendee instances.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->storeValidator($request->all());

        return response()
            ->json([
                'success' => true,
                'attendees' => $this->contract->store(
                    User::where('id', $request->get('user'))->firstOrFail(),
                    collect($request->input('attendees')),
                    false
                )
            ]);
    }

    /**
     * Return the validator instance.
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function updateValidator($data)
    {
        return Validator::make($data, [
            'email' => 'email',
            'ticket.id' => 'exists:tickets,id'
        ]);
    }

    /**
     * Update the attendee instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Jano\Models\Attendee $attendee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendee $attendee)
    {
        $data = $request->all();

        $this->updateValidator($data);

        $return = $this->contract->update($attendee, $data);

        return response()->json([
            'success' => true,
            'attendee' => $return
        ]);
    }

    /**
     * Destroy the attendee instance.
     *
     * @param \Jano\Models\Attendee $attendee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendee $attendee)
    {
        $this->contract->destroy($attendee);

        return response()->json([
            'success' => true
        ]);
    }
}
