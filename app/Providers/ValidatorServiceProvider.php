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

namespace Jano\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Jano\Facades\Helper;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap validator services.
     *
     * @throws \InvalidArgumentException
     */
    public function boot()
    {
        $this->loadSumBetweenValidation();
        $this->loadPreferencesValidation();
    }

    /**
     * Load the `sum_between` validator.
     */
    private function loadSumBetweenValidation()
    {
        Validator::extend('sum_between', function ($attribute, $value, $parameters, $validator) {
            if (isset($parameters[2])) {
                $segments = explode('.*', $parameters[2], -1);
                if (empty($segments) && $parameters[2] !== '*') {
                    throw new InvalidArgumentException('The sum_between rule must take an array.');
                }

                $array = Helper::flattenArrayKey($validator->getData());

                $value = collect($array)->filter(function ($value, $index) use ($parameters) {
                    $regex = '/' . str_replace(
                            '*',
                            '[^\.\n\r]+?',
                            str_replace('.', '\.', $parameters[2])
                        ) . '/';

                    return preg_match($regex, $index);
                });
            } elseif (is_array($value)) {
                $value = collect($value);
            } else {
                throw new InvalidArgumentException('The sum_between rule must take an array.');
            }

            $sum = $value->sum();
            return $sum <= $parameters[1] && $sum >= $parameters[0];
        });

        Validator::replacer('sum_between', function ($message, $attribute, $rule, $parameters) {
            $needle = array(':min', ':max');
            $value = array($parameters[0], $parameters[1]);
            return str_replace($needle, $value, $message);
        });
    }

    /**
     * Load the `preferences` validator.
     */
    private function loadPreferencesValidation()
    {
        Validator::extend('preferences', function ($attribute, $value, $parameters, $validator) {
            if (empty($value) || !is_array($value)) {
                $validation = false;
            } else {
                $array = array_map('intval', $value);
                asort($array, SORT_NUMERIC);

                $i = 1;
                $validation = true;

                foreach ($array as $number) {
                    if ($number !== 0) {
                        if ($number !== $i) {
                            $validation = false;
                            break;
                        }

                        ++$i;
                    }
                }
            }

            return $validation;
        });
    }
}
