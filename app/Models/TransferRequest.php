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
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $college
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
     * Create a new ticket transfer request.
     *
     * @param \Jano\Models\User $user
     * @param \Jano\Models\Attendee $attendee
     * @param array $data
     * @return \Jano\Models\TransferRequest
     */
    public static function create(User $user, Attendee $attendee, $data)
    {
        $request = new self();
        $request->user_id = $user->id;
        $request->attendee_id = $attendee->id;
        $request->title = $data['title'];
        $request->first_name = $data['first_name'];
        $request->last_name = $data['last_name'];
        $request->email = $data['email'];
        $request->college = $data['college'];
        $request->primary_ticket_holder = $attendee->primary_ticket_holder;
        $request->processed = false;
        $request->save();

        return $request;
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attendee()
    {
        return $this->hasOne('Jano\Models\Attendee');
    }

    /**
     * The new attendee associated with the ticket transfer request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function newAttendee()
    {
        return $this->hasOne('Jano\Models\Attendee', 'id', 'new_attendee_id');
    }
}
