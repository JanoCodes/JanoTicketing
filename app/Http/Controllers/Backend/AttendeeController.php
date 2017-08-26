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

namespace Jano\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Jano\Contracts\AttendeeContract;
use Jano\Http\Controllers\Controller;
use Jano\Http\Traits\RendersAjaxView;
use Jano\Models\Attendee;

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
        return $this->ajaxView($request, 'backend.attendees.index', [
            'attendees' => Attendee::withTrashed()->paginate()
        ]);
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
     *
     * Renders the attendee edit page.
     *
     * @param \Jano\Models\Attendee $attendee
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendee $attendee)
    {
        return view('backend.attendees.edit', [
            'attendee' => $attendee
        ]);
    }
}
