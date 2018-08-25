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

namespace Jano\Modules\TicketRequest\Widgets\Backend;

use Arrilot\Widgets\AbstractWidget;
use Jano\Modules\TicketRequest\Models\TicketRequest;

class RequestsCountBadge extends AbstractWidget
{
    /**
     * Wrap badget in `callout` container
     *
     * @return array
     */
    public function container()
    {
        return [
            'element'       => 'div',
            'attributes'    => 'class="callout"',
        ];
    }

    /**
     * Render the attendees count badge
     */
    public function run()
    {
        return view('ticket-request::widgets.backend.requests_count_badge', [
            'attendees_count' => TicketRequest::count(),
        ]);
    }
}