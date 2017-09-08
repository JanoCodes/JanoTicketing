<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2017 Andrew Ying
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v3.0 as
 * published by the Free Software Foundation. You must preserve all legal
 * notices and author attributions present.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Jano\Repositories;

use Hashids\Hashids;
use InvalidArgumentException;
use Jano\Models\User;
use Jano\Settings\Facade as Setting;

class HelperRepository
{
    /**
     * Convert array index to snake case.
     *
     * @param array $array
     * @param string $prefix
     * @return array
     */
    public static function flattenArrayKey(array $array, $prefix = '')
    {
        $result = array();

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge(
                    $result,
                    self::flattenArrayKey($value, $prefix . $key . '.')
                );
            } else {
                $result[$prefix . $key] = $value;
            }
        }

        return $result;
    }

    /**
     * Return the user-specific price.
     *
     * @param int $price
     * @param \Jano\Models\User $user
     * @param bool $full
     * @return int|string
     */
    public static function getUserPrice($price, User $user, $full = true)
    {
        $price += $user->surcharge;

        if ($full) {
            $price = Setting::get('payment.currency') . $price;
        }

        return $price;
    }

    /**
     * Generate a unique random hash ID.
     *
     * @param int $length
     * @return string
     * @throws \Hashids\HashidsException
     */
    public static function generateUuid($length = 12)
    {
        $hashids = new Hashids(config('app.key'));

        return $hashids->encode(self::bcRandomInteger(0, bcpow(62, $length)));
    }

    /**
     * Generate an random integer.
     *
     * @param mixed $min
     * @param mixed $max
     * @return string
     * @throws \InvalidArgumentException
     */
    protected static function bcRandomInteger($min, $max)
    {
        if (bccomp($max, $min) !== 1) {
            throw new InvalidArgumentException('Minimum value must be less than the maximum value');
        }

        $desired = bcsub($max, $min);

        if (bccomp($desired, bcmul(PHP_INT_MAX, 10 ** 5)) === 1) {
            throw new InvalidArgumentException('The range is too large for efficient random integer generation.');
        }

        $return = $min;

        while (bccomp($desired, PHP_INT_MAX) === 1) {
            $return = bcadd($return, random_int(0, PHP_INT_MAX));
            $desired = bcsub($desired, PHP_INT_MAX);
        }

        $return = bcadd($return, random_int(0, (int) $desired));

        return $return;
    }
}
