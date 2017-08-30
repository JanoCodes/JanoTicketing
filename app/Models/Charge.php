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
use Setting;

/**
 * Class Charge
 *
 * @property int $amount
 * @property string $full_amount
 * @property string $description
 * @property \Carbon\Carbon $due_at
 * @property boolean $paid
 */
class Charge extends Model implements AuditableContract
{
    use Auditable, SoftDeletes;

    /**
     * List of attributes to be appended to the model.
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
    protected $dates = ['due_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'paid' => 'boolean',
    ];

    /**
     * The account the charge belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('\Jano\Models\Account');
    }

    /**
     * The attendees associated with the charge.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendees()
    {
        return $this->hasMany('Jano\Models\Attendee');
    }

    /**
     * The transfer request associated with the charge.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transferRequest()
    {
        return $this->hasOne('Jano\Models\TransferRequest');
    }

    /**
     * Return the human-readable version of the amount due.
     *
     * @return string
     */
    public function getFullAmountAttribute()
    {
        return Setting::get('payment.currency') . $this->amount;
    }
}
