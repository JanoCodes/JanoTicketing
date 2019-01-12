<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2019 Andrew Ying and other contributors.
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Affero General Public License
 * v3.0 supplemented by additional permissions and terms as published at
 * COPYING.md.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 */

namespace Jano\Models\Traits;

use Setting;

/**
 * Trait Chargeable
 *
 * @property int $price
 *
 */
trait Chargeable
{
    /**
     * The charge associated with the attendee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function charge()
    {
        return $this->morphMany('Jano\Models\Charge', 'chargeable');
    }

    /**
     * Return the price of the item.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Return human-readable price of the item.
     *
     * @return string
     */
    public function getFullPrice()
    {
        return Setting::get('payment.currency') . $this->price;
    }
}
