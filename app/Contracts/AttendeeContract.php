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

namespace Jano\Contracts;

use Illuminate\Support\Collection;
use Jano\Models\Attendee;
use Jano\Models\User;

interface AttendeeContract
{
    /**
     * Store new attendees instances.
     *
     * @param \Jano\Models\User $user
     * @param \Illuminate\Support\Collection $tickets
     * @param boolean $frontend
     * @return \Illuminate\Support\Collection
     */
    public function store(
        User $user,
        Collection $tickets,
        $frontend = true
    );

    /**
     * Retreive collection of all attendees.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index();

    /**
     * Retrieve collection of attendees.
     *
     * @param $query
     * @return \Illuminate\Support\Collection
     */
    public function search($query);

    /**
     * Update the attributes of the attendee instance.
     *
     * @param \Jano\Models\Attendee $attendee
     * @param array $data
     * @return \Jano\Models\Attendee
     */
    public function update(Attendee $attendee, $data);

    /**
     * Export attendee instances.
     *
     * @param array $fields
     * @return array
     */
    public function export(array $fields = []);

    /**
     * Destroy an attendee instance.
     *
     * @param \Jano\Models\Attendee|\Illuminate\Support\Collection $attendee
     * @return void
     */
    public function destroy($attendee);
}
