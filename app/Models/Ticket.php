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
use Jano\Events\TicketChanged;
use Spatie\Translatable\HasTranslations;

/**
 * Class Ticket
 *
 * @property int $id
 * @property string $name
 * @property int $price
 */
class Ticket extends Model
{
    use CanCache;

    protected $dispatchesEvent = [
        'saved' => TicketChanged::class,
        'deleted' => TicketChanged::class,
    ];

    /**
     * Ticket constructor; defines the number of minutes cache should persists for.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->expire = -1;
    }

    /**
     * Create new ticket.
     *
     * @param array $data
     * @return \Jano\Models\Ticket
     */
    public static function create($data)
    {
        $ticket = new self();
        $ticket->name = $data['name'];
        $ticket->price = $data['price'];
        $ticket->save();

        return $ticket;
    }

    /**
     * The attendees associated with the ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendees()
    {
        return $this->hasMany('Jano\Models\Attendee');
    }
}
