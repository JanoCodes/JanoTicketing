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
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class Payment
 *
 * @property int $id
 * @property int $account_id
 * @property string $type
 * @property int $amount
 * @property string $full_amount
 * @property string $reference
 * @property string $internal_reference
 * @property \Carbon\Carbon $made_at
 */
class Payment extends Model implements AuditableContract
{
    use Auditable;

    /**
     * The array of attributes which should be appended to the model.
     *
     * @var array
     */
    protected $appends = ['full_amount'];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['account'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['made_at'];

    /**
     * The account associated with the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('Jano\Models\Account');
    }

    /**
     * Return the human-readable version of the amount paid.
     *
     * @return string
     */
    public function getFullAmountAttribute()
    {
        return Setting::get('payment.currency') . $this->amount;
    }
}
