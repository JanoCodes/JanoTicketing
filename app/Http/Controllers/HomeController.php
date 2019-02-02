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

namespace Jano\Http\Controllers;

use Carbon\Carbon;
use Kris\LaravelFormBuilder\FormBuilder;
use Jano\Http\Traits\WithAuthenticationForms;
use Setting;

class HomeController extends Controller
{
    use WithAuthenticationForms;

    /**
     * Show the application dashboard.
     *
     * @param \Kris\LaravelFormBuilder\FormBuilder $builder
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $builder)
    {
        $login = $this->loginForm($builder);
        $register = $this->registerForm($builder);

        $event_date = [
            'from' => Carbon::parse(Setting::get('event.date.from')),
            'to' => Carbon::parse(Setting::get('event.date.to'))
        ];

        return view('home', [
            'event_date' => $event_date,
            'login' => $login,
            'register' => $register
        ]);
    }
}
