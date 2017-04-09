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
use Ramsey\Uuid\Uuid;

class Attendee extends Model
{
    use SoftDeletes;

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['user', 'order'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Create new attendees.
     *
     * @param \Jano\Models\Order $order
     * @param array $data
     * @return array
     */
    public static function createMany(Order $order, $data)
    {
        $user_id = $order->user->id;
        $order_id = $order->id;
        $attendees = array();

        foreach($data as $data_entry) {
            $attendee = new self();
            $attendee->uuid = Uuid::uuid4();
            $attendee->user_id = $user_id;
            $attendee->order_id = $order_id;
            $attendee->title = $data_entry['title'];
            $attendee->first_name = $data_entry['first_name'];
            $attendee->last_name = $data_entry['last_name'];
            $attendee->email = $data_entry['email'];
            $attendee->college = $data_entry['college'];
            $attendee->primary_ticket_holder = $data_entry['primary_ticket_holder'];
            $attendee->ticket_id = $data_entry['ticket_id'];
            $attendee->checked_in = false;
            $attendee->save();

            $attendees[] = $attendee;
        }

        return $attendees;
    }

    /**
     * The user associated with the attendee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Jano\Models\User');
    }

    /*
     * The ticket type associated with the attendee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo('Jano\Models\Ticket');
    }

    /*
     * The order associated with the attendee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('Jano\Models\Order');
    }

    /*
     * The ticket request associated with the attendee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ticketRequest()
    {
        return $this->hasOne('Jano\Models\TicketRequest');
    }

    /*
     * The transfer request associated with the attendee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transferRequest()
    {
        return $this->hasOne('Jano\Models\TransferRequest');
    }
}
