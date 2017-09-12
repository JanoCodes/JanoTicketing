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

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Jano\Http\Controllers\Controller;
use Jano\Http\Traits\RendersAjaxView;
use Jano\Models\Attendee;
use Jano\Models\Charge;
use Jano\Models\TicketRequest;
use Parsedown;

class HomeController extends Controller
{
    use RendersAjaxView;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'staff']);
    }

    /**
     * Render the backend dashboard page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->ajaxView($request, 'backend.home', [
            'attendees' => Attendee::latest()->get()->take(5),
            'attendees_count' => Attendee::count(),
            'charges_total' => Charge::sum('amount'),
            'requests_count' => TicketRequest::count()
        ]);
    }

    /**
     * Render the backend about page.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        $credits_raw = (new Filesystem())->get(base_path('CREDITS.md'));

        return view('backend.about', [
            'credits' => (new Parsedown())->text($credits_raw)
        ]);
    }
}
