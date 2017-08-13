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

use Jano\Models\Staff;
use Jano\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StaffPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create a new staff instance.
     *
     * @param \Jano\Models\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->staff()->access_level >= 100;
    }

    /**
     * Determine whether the user can update the staff instance.
     *
     * @param \Jano\Models\User $user
     * @param \Jano\Models\Staff $staff
     * @return bool
     */
    public function update(User $user, Staff $staff)
    {
        $user_access = $user->staff()->access_level;

        return ($user_access >= 100 && $staff->access_level <= $user_access);
    }

    /**
     * Determine whether the user can destroy the staff instance.
     *
     * @param \Jano\Models\User $user
     * @param \Jano\Models\Staff $staff
     * @return bool
     */
    public function destroy(User $user, Staff $staff)
    {
        $active_staff = $user->staff();

        return (
            $active_staff->access_level >= 100 &&
            $staff->access_level <= $active_staff &&
            $active_staff !== $staff
        );
    }
}
