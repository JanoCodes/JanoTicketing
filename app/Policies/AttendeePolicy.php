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

namespace Jano\Policies;

use Carbon\Carbon;
use Jano\Models\User;
use Jano\Models\Attendee;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the attendee.
     *
     * @param  \Jano\Models\User  $user
     * @param  \Jano\Models\Attendee  $attendee
     * @return mixed
     */
    public function view(User $user, Attendee $attendee)
    {
        return $attendee->user_id = $user->id;
    }

    /**
     * Determine whether the user can create attendees.
     *
     * @param  \Jano\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return (!$user->can_order_at || $user->can_order_at->gt(Carbon::now()));
    }

    /**
     * Determine whether the user can update the attendee.
     *
     * @param  \Jano\Models\User  $user
     * @param  \Jano\Models\Attendee  $attendee
     * @return mixed
     */
    public function update(User $user, Attendee $attendee)
    {
        return $attendee->user_id = $user->id;
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  \Jano\Models\User  $user
     * @param  \Jano\Models\Attendee  $attendee
     * @return mixed
     */
    public function delete(User $user, Attendee $attendee)
    {
        return ($attendee->user_id === $user->id) && (!$attendee->paid);
    }
}
