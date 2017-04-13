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
use Illuminate\Notifications\Notifiable;

/**
 * Class Collection
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property boolean $collected
 * @property \Carbon\Carbon $collected_at
 */
class Collection extends Model
{
    use Notifiable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['collected_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'collected' => 'boolean',
    ];

    /**
     * Create a new collection.
     *
     * @param \Jano\Models\User $user
     * @return \Jano\Models\Collection
     */
    public static function create(User $user)
    {
        $collection = new self();
        $collection->user_id = $user->id;
        $collection->first_name = $user->first_name;
        $collection->last_name = $user->last_name;
        $collection->email = $user->email;
        $collection->collected = false;
        $collection->save();

        return $collection;
    }

    /**
     * The user associated with the collection
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Jano\Models\User');
    }

    /**
     * The attendees associated with the collection
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function attendees()
    {
        return $this->hasManyThrough('Jano\Models\Attendee', 'Jano\Models\User');
    }
}
