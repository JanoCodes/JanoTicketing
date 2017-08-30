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
use Setting;

/**
 * Class Account
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount_due
 * @property string $full_amount_due
 * @property int $amount_paid
 * @property string $full_amount_paid
 * @property int $amount_outstanding
 * @property string $full_amount_outstanding
 */
class Account extends Model
{
    /**
     * The attributes which should be appended to the account instance.
     *
     * @var array
     */
    protected $appends = [
        'full_amount_due',
        'full_amount_paid',
        'amount_outstanding',
        'full_amount_outstanding'
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['user'];

    /**
     * The user which the account belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Jano\Models\User');
    }

    /**
     * The charges associated with the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function charges()
    {
        return $this->hasMany('Jano\Models\Charge');
    }

    /**
     * The payments associated with the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('Jano\Models\Payment');
    }

    /**
     * Return the human-readable version of the amount due.
     *
     * @return string
     */
    public function getFullAmountDueAttribute()
    {
        return Setting::get('payment.currency') . $this->amount_due;
    }

    /**
     * Return the human-readable version of the amount paid.
     *
     * @return string
     */
    public function getFullAmountPaidAttribute()
    {
        return Setting::get('payment.currency') . $this->amount_paid;
    }

    /**
     * Return the amount which remains unpaid.
     *
     * @return int
     */
    public function getAmountOutstandingAttribute()
    {
        return $this->amount_due - $this->amount_paid;
    }

    /**
     * Return the human-readable version of the amount paid.
     *
     * @return string
     */
    public function getFullAmountOutstandingAttribute()
    {
        return Setting::get('payment.currency') . $this->amount_outstanding;
    }
}
