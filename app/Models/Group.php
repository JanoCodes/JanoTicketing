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

use Illuminate\Database\Eloquent\Model;
use Jano\Cacheable\Eloquent\CanCache;

/**
 * Class Group
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property \Carbon\Carbon $can_order_at
 * @property int $ticket_limit
 * @property int $surcharge
 * @property int $right_to_buy
 */
class Group extends Model
{
    use CanCache;

    protected $dispatchesEvent = [
        'saved' => \Jano\Events\GroupChanged::class,
        'deleted' => \Jano\Events\GroupChanged::class,
    ];

    /**
     * Group constructor; defines the number of minutes cache should persists for.
     */
    public function __construct()
    {
        parent::__construct();

        $this->expire = -1;
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
}
