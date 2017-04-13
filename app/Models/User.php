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

namespace Jano\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int $id
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $method
 * @property string $password
 * @property int $oauth_id
 * @property int $group_id
 * @property string $college
 * @property string $phone
 * @property int $right_to_buy
 * @property int $guaranteed_addon
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'oauth_id',
    ];

    /**
     * Create a new user.
     *
     * @param array $data
     * @return \Jano\Models\User
     */
    public static function create($data)
    {
        $user = new self();
        $user->title = $data['title'] ?? null;
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->method = $data['method'];
        $user->password = isset($data['password']) ? bcrypt($data['password']) : null;
        $user->oauth_id = $data['oauth_id'] ?? null;
        $user->group_id = $data['group_id'];
        $user->college = $data['college'];
        $user->phone = $data['phone'] ?? null;
        $user->right_to_buy = $data['right_to_buy'] ?? null;
        $user->guranteed_addon = $data['guranteed_addon'] ?? null;
        $user->save();

        return $user;
    }

    /**
     * The group associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('Jano\Models\Group');
    }

    /**
     * The administrator associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function administrator()
    {
        return $this->hasOne('Jano\Models\Administrator');
    }

    /**
     * The attendees associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendees()
    {
        return $this->hasMany('Jano\Models\Attendee');
    }

    /**
     * The orders associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('Jano\Models\Order');
    }

    /**
     * The payments associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('Jano\Models\Payment');
    }

    /**
     * The ticket transfer requests associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transferRequest()
    {
        return $this->hasMany('Jano\Models\TransferRequest');
    }

    /**
     * The ticket requests associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ticketRequest()
    {
        return $this->hasMany('Jano\Models\TicketRequest');
    }

    /**
     * The ticket collection associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function collection()
    {
        return $this->hasOne('Jano\Models\Collection');
    }
}
