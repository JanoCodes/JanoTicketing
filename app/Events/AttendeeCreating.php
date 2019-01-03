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

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Jano\Models\Attendee;

class AttendeeCreating
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Jano\Models\Attendee
     */
    public $attendee;

    /**
     * @var array
     */
    public $data;

    /**
     * AttendeeCreating event constructor.
     *
     * @param \Jano\Models\Attendee $attendee
     * @param array $data
     */
    public function __construct(Attendee $attendee, $data)
    {
        $this->attendee = $attendee;
        $this->data = $data;
    }
}
