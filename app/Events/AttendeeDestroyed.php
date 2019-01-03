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

namespace Jano\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class AttendeeDestroyed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Illuminate\Support\Collection|\Jano\Models\Attendee
     */
    public $attendee;

    /**
     * Create a new event instance.
     *
     * @param \Jano\Models\Attendee|\Illuminate\Support\Collection $attendee
     * @return void
     */
    public function __construct($attendee)
    {
        $this->attendee = $attendee;
    }
}
