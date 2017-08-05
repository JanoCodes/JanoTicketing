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

namespace Jano\Repositories;

use Carbon\Carbon;
use InvalidArgumentException;
use Jano\Contracts\CollectionContract;
use Jano\Models\Collection;
use Jano\Models\User;

class CollectionRepository implements CollectionContract
{
    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function store(User $user)
    {
        if ($user->attendees()->count() === 0) {
            throw new InvalidArgumentException('The user does not have any tickets to collect.');
        }

        $collection = new Collection();
        $collection->user()->associate($user);
        $collection->first_name = $user->first_name;
        $collection->last_name = $user->last_name;
        $collection->email = $user->email;
        $collection->save();

        return $collection;
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function update(Collection $collection, $data)
    {
        if ($collection->collected) {
            throw new InvalidArgumentException('The collection has already been made.');
        }

        $collection->first_name = $data['first_name'];
        $collection->last_name = $data['last_name'];
        $collection->email = $data['email'];
        $collection->save();

        return $collection;
    }

    /**
     * @inheritdoc
     */
    public function collect(Collection $collection)
    {
        $collection->collected = true;
        $collection->collected_at = Carbon::now();

        return $collection;
    }
}