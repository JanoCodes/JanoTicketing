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
 * Class TransferRequest
 *
 * @property int $id
 * @property int $user_id
 * @property int $attendee_id
 * @property string $old_title
 * @property string $old_first_name
 * @property string $old_last_name
 * @property string $old_email
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property boolean $primary_ticket_holder
 * @property int $new_user_id
 * @property int $price_difference
 * @property boolean $processed
 * @property \Carbon\Carbon $processed_at
 * @property int $new_attendee_id
 */
class TransferRequest extends Model
{
    use SoftDeletes;

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['user', 'order', 'attendee'];

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
        'primary_ticket_holder' => 'boolean',
        'processed' => 'boolean',
    ];

    /**
     * The user associated with the ticket transfer request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Jano\Models\User');
    }

    /**
     * The order associated with the ticket transfer request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('Jano\Models\Order');
    }

    /**
     * The attendee associated with the ticket transfer request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attendee()
    {
        return $this->belongsTo('Jano\Models\Attendee');
    }

    /**
     * The new attendee associated with the ticket transfer request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function newAttendee()
    {
        return $this->belongsTo('Jano\Models\Attendee', 'id', 'new_attendee_id');
    }
}
