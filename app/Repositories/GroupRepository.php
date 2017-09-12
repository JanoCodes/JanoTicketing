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

namespace Jano\Repositories;

use Jano\Contracts\GroupContract;
use Jano\Models\Group;

class GroupRepository implements GroupContract
{
    /**
     * @inheritdoc
     */
    public function store($data)
    {
        $group = new Group();
        $group->slug = $group['slug'];
        $group->name = $group['name'];
        $group->can_order_at = $group['can_order_at'];
        $group->ticket_limit = $group['ticket_limit'];
        $group->surcharge = $group['surcharge'];
        $group->right_to_buy = $group['right_to_buy'];
        $group->save();

        return $group;
    }

    /**
     * @inheritdoc
     */
    public function search($query)
    {
        $query = $query ? '%' . $query . '%' : '%';

        return Group::where('name', 'like', $query)
            ->orWhere('slug', 'like', $query)
            ->paginate();
    }

    /**
     * @inheritdoc
     */
    public function update(Group $group, $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritdoc
     */
    public function destroy(Group $group)
    {
        // TODO: Implement destroy() method.
    }
}