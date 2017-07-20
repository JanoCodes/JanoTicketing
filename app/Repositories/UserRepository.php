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

use InvalidArgumentException;
use Jano\Contracts\UserContract;
use Jano\Models\User;

class UserRepository implements UserContract
{
    /**
     * @inheritdoc
     */
    public function store($data)
    {
        $user = new User();
        $user->title = $data['title'] ?? null;
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->method = $data['method'];
        $user->password = $data['method'] === User::DATABASE_METHOD ? bcrypt($data['password']) : null;
        $user->oauth_id = $data['method'] === User::OAUTH_METHOD ?? $data['oauth_id'];
        $user->group_id = $data['group_id'];
        $user->phone = $data['phone'] ?? null;
        $user->can_order_at = $data['can_order_at'] ?? null;
        $user->ticket_limit = $data['ticket_limit'] ?? null;
        $user->surcharge = $data['surcharge'] ?? null;
        $user->right_to_buy = $data['right_to_buy'] ?? null;
        $user->save();

        return $user;
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function update(User $user, $data)
    {
        $user->title = $data['title'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];

        if (isset($data['password'])) {
            if (empty($user->oauth_id)) {
                $user->password = bcrypt($data['password']);
            } else {
                throw new InvalidArgumentException('Password cannot be updated for users authenticated via OAuth.');
            }
        }

        $user->group_id = $data['group_id'];
        $user->phone = $data['phone'];
        $user->can_order_at = $data['can_order_at'];
        $user->ticket_limit = $data['ticket_limit'];
        $user->surcharge = $data['surcharge'];
        $user->right_to_buy = $data['right_to_buy'];
        $user->save();

        return $user;
    }
}
