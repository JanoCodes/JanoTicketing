<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2019 Andrew Ying and other contributors.
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

namespace Jano\Repositories;

use InvalidArgumentException;
use Illuminate\Support\Facades\Hash;
use Jano\Contracts\UserContract;
use Jano\Models\Account;
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
        $user->password = $data['method'] === User::DATABASE_METHOD ? Hash::make($data['password']) : null;
        $user->oauth_id = $data['method'] === User::OAUTH_METHOD ?? $data['oauth_id'];
        $user->group_id = $data['group_id'];
        $user->phone = $data['phone'] ?? null;
        $user->can_order_at = $data['can_order_at'] ?? null;
        $user->ticket_limit = $data['ticket_limit'] ?? null;
        $user->surcharge = $data['surcharge'] ?? null;
        $user->right_to_buy = $data['right_to_buy'] ?? null;
        $user->save();

        $account = new Account();
        $account->user()->associate($user);
        $account->amount_due = 0;
        $account->amount_paid = 0;
        $account->save();

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function search($query)
    {
        $query = $query ? '%' . $query . '%' : '%';

        return User::where('first_name', 'like', $query)
            ->orWhere('last_name', 'like', $query)
            ->orWhere('email', 'like', $query)
            ->with(['account', 'group'])
            ->paginate();
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function update(User $user, $data)
    {
        foreach ($data as $attribute => $value) {
            if ($attribute === 'password') {
                if (empty($user->oauth_id)) {
                    $user->password = bcrypt($data['password']);
                } else {
                    throw new InvalidArgumentException('Password cannot be updated for users authenticated via OAuth.');
                }
            } else {
                $user->{$attribute} = $value;
            }
        }
        $user->save();

        return $user;
    }
}
