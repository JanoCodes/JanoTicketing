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
 * @property string $phone
 * @property \Carbon\Carbon $can_order_at
 * @property int $ticket_limit
 * @property int $surcharge
 * @property int $right_to_buy
 */
class User extends Authenticatable
{
    use Notifiable;

    const DATABASE_METHOD = 'database';
    const OAUTH_METHOD = 'oauth';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'oauth_id',
    ];

    /**
     * The relationships to eager-load automatically.
     *
     * @var array
     */
    protected $with = ['group'];

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
     * The account associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account()
    {
        return $this->hasOne('Jano\Models\Account');
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
     * The payments associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('Jano\Models\Payment');
    }

    /**
     * The staff associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function staff()
    {
        return $this->hasOne('Jano\Models\Staff');
    }

    /**
     * The ticket transfer requests associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transferRequests()
    {
        return $this->hasMany('Jano\Models\TransferRequest');
    }

    /**
     * The ticket requests associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ticketRequests()
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

    /**
     * Get the date at which the user can place a ticket order.
     *
     * @param $value
     * @return \Carbon\Carbon
     */
    public function getCanOrderAtAttribute($value)
    {
        return empty($value) ? $this->group->can_order_by : $value;
    }

    /**
     * Get the limit on number of tickets of the user.
     *
     * @param $value
     * @return int
     */
    public function getTicketLimitAttribute($value)
    {
        return empty($value) ? $this->group->ticket_limit : $value;
    }

    /**
     * Get the surcharge which applies for the user.
     *
     * @param $value
     * @return int
     */
    public function getSurchargeAttribute($value)
    {
        return empty($value) ? $this->group->surcharge : $value;
    }

    /**
     * Get the number of tickets the user is entitled to buy.
     *
     * @param $value
     * @return int
     */
    public function getRightToBuyAttribute($value)
    {
        return empty($value) ? $this->group->right_to_buy : $value;
    }
}
