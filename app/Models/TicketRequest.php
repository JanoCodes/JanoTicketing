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
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

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
 * @property \Jano\Models\Ticket $preferred_ticket
 * @property boolean $right_to_buy
 * @property int $priority
 * @property boolean $honoured
 * @property \Carbon\Carbon $honoured_at
 * @property int $attendee_id
 */
class TicketRequest extends Model implements AuditableContract
{
    use Auditable, SoftDeletes;

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['user'];

    /**
     * The attributes that should be appended to the model.
     *
     * @var array
     */
    protected $appends = ['preferred_ticket'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['honoured_at', 'deleted_at'];

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

    /**
     * The attendee associated with the honoured ticket request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attendee()
    {
        return $this->belongsTo('Jano\Models\Attendee');
    }

    /**
     * Return the preferred ticket type.
     *
     * @return \Jano\Models\Ticket
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPreferredTicket()
    {
        $id = array_search(1, $this->ticket_preference, false);

        return Ticket::where('id', $id)->firstOrFail();
    }
}
