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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TicketRequest
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property array $ticket_preference
 * @property boolean $right_to_buy
 * @property int $priority
 * @property int $status
 * @property int $attendee_id
 */
class TicketRequest extends Model
{
    use SoftDeletes;

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['user'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ticket_preference' => 'array',
        'right_to_buy' => 'boolean',
        'guaranteed_addon' => 'boolean',
    ];

    /**
     * The user associated with the ticket request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Jano\Models\User');
    }
}
