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
use Spatie\Translatable\HasTranslations;

/**
 * Class Group
 *
 * @property int $id
 * @property string $slug
 * @property \Carbon\Carbon $can_order_at
 * @property int $ticket_limit
 * @property int $surcharge
 * @property int $right_to_buy
 * @property int $guaranteed_addon
 */
class Group extends Model
{
    use HasTranslations;

    /**
     * The attributes which can be translated.
     *
     * @var array
     */
    public $translatable = ['name'];

    /**
     * Create a new group
     *
     * @param array $data
     * @return \Jano\Models\Group
     */
    public static function create($data)
    {
        $group = new self();
        $group->slug = $data['slug'];
        $group->name = $data['name'];
        $group->can_order_at = $data['can_order_at'];
        $group->ticket_limit = $data['ticket_limit'];
        $group->surcharge = $data['surcharge'];
        $group->right_to_buy = $data['right_to_buy'] ?? 0;
        $group->guaranteed_addon = $data['guranteed_addon'] ?? 0;
        $group->save();

        return $group;
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
