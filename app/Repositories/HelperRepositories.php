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

namespace Jano\Repositories;

class HelperRepositories
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
}
