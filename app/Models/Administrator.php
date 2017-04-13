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

/**
 * Class Administrator
 *
 * @property int $id
 * @property int $user_id
 * @property int $access_level
 */
class Administrator extends Model
{
    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['user'];

    /**
     * Create a new administrator.
     *
     * @param \Jano\Models\User $user
     * @param int $level
     * @return \Jano\Models\Administrator
     */
    public static function create(User $user, $level)
    {
        $admin = new self();
        $admin->user_id = $user->id;
        $admin->access_level = $level;
        $admin->save();

        return $admin;
    }

    /**
     * The user associated with the administrator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Jano\Models\User');
    }
}
