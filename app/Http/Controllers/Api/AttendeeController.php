<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2018 Andrew Ying and other contributors.
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Affero General Public License
 * v3.0 as published by the Free Software Foundation. You must preserve
 * all legal notices and author attributions present.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see
 * <http://www.gnu.org/licenses/>.
 */

namespace Jano\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Jano\Contracts\AttendeeContract;
use Jano\Http\Controllers\Controller;
use Jano\Models\Attendee;
use Validator;

class AttendeeController extends Controller
{
    /**
     * @var \Jano\Contracts\AttendeeContract
     */
    private $attendee;

    /**
     * AttendeeController constructor.
     *
     * @param \Jano\Contracts\AttendeeContract $attendee
     */
    public function __construct(AttendeeContract $attendee)
    {
        $this->attendee = $attendee;
        $this->middleware('auth:api');
    }

    /**
     * Return list of all attendees.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->middleware('scopes:attendees-index');

        $attendees = $this->attendee->index();

        if ($request->has('updated_at')) {
            $updated_at = Carbon::parse($request->get('updated_at'));
            $attendees = $attendees->where('updated_at', '>=', $updated_at)->values()->all();
        }
        if ($request->has('paginate')) {
            $attendees = $attendees->paginate($request->get('paginate'));
        }

        return response()->json($attendees);
    }

    /**
     * Get a validator for attendees.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function updateValidator($data)
    {
        $rules = array(
            'email' => 'sometimes|required|email',
            'ticket' => 'sometimes|required|exists:tickets,id',
            'checked_in' => 'sometimes|required|boolean',
            'checked_in_at' => 'required_with:checked_in|date',
        );

        return Validator::make($data, $rules);
    }

    /**
     * Update attendee attributes.
     *
     * @param \Jano\Models\Attendee $attendee
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Attendee $attendee, Request $request)
    {
        $this->middleware(['scopes:attendees-update']);

        $data = $request->input();
        $this->updateValidator($data);

        $attendee = $this->attendee->update($attendee, $data);
        return response()->json($attendee);
    }
}
