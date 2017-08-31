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

namespace Jano\Contracts;

use Jano\Models\User;

interface UserContract
{
    /**
     * Store the user instance.
     *
     * @param array $data
     * @return \Jano\Models\User
     */
    public function store($data);

    /**
     * Retrieve a collection of user.
     *
     * @param $query
     * @return \Illuminate\Support\Collection
     */
    public function search($query);

    /**
     * Update the user instance.
     *
     * @param \Jano\Models\User $user
     * @param array $data
     * @return \Jano\Models\User
     */
    public function update(User $user, $data);
}