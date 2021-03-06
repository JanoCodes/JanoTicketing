<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2018 Andrew Ying and other contributors.
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

namespace Jano\Models;

use Illuminate\Database\Eloquent\Model;
use Setting;

/**
 * Class Group
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property \Carbon\Carbon $can_order_at
 * @property int $ticket_limit
 * @property int $surcharge
 * @property string $full_surcharge
 * @property int $right_to_buy
 */
class Group extends Model
{
    /**
     * The array of attributes which should be appended to the model.
     *
     * @var array
     */
    protected $appends = ['full_surcharge'];

    protected $dispatchesEvent = [
        'saved' => \Jano\Events\GroupChanged::class,
        'deleted' => \Jano\Events\GroupChanged::class,
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['can_order_at'];

    /**
     * Group constructor; defines the number of minutes cache should persists for.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The users associated with the group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany('Jano\Models\User');
    }

    /**
     * Return the human-readable version of the surcharge.
     *
     * @return string
     */
    public function getFullSurchargeAttribute()
    {
        return Setting::get('payment.currency') . $this->surcharge;
    }
}
