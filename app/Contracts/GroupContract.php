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

namespace Jano\Contracts;

use Jano\Models\Group;

interface GroupContract
{
    /**
     * Store a newly created group instance.
     *
     * @param array $data
     * @return \Jano\Models\Group
     */
    public function store($data);

    /**
     * Retrieve a collection of group instance.
     *
     * @param mixed $query
     * @return \Illuminate\Support\Collection
     */
    public function search($query);

    /**
     * Update the attributes of the group instance.
     *
     * @param \Jano\Models\Group $group
     * @param array $data
     * @return \Jano\Models\Group
     */
    public function update(Group $group, $data);

    /**
     * Destroy the group instance.
     *
     * @param \Jano\Models\Group $group
     * @return void
     */
    public function destroy(Group $group);
}
