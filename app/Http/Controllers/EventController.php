<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2019 Andrew Ying and other contributors.
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Affero General Public License
 * v3.0 supplemented by additional permissions and terms as published at
 * COPYING.md.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 */

namespace Jano\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Jano\Models\Ticket;
use Setting;

class EventController extends Controller
{
    /**
     * EventController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show event page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->session()->pull('reservation');
        $event_date = [
            'from' => Carbon::parse(Setting::get('event.date.from')),
            'to' => Carbon::parse(Setting::get('event.date.to'))
        ];

        return view('event', [
            'user' => $request->user(),
            'tickets' => Ticket::all(),
            'event_date' => $event_date
        ]);
    }
}
