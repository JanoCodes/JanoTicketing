<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2018 Andrew Ying
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

namespace Jano\Modules\TransferRequest\Widgets;

use Auth;
use Arrilot\Widgets\AbstractWidget;

class AccountRequests extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'user' => null
    ];

    /**
     * Render the transfer requests widget
     */
    public function run()
    {
        return view('transfer-request::widgets.account_requests', [
            'user' => $this->config['user'] ?? Auth::user()
        ]);
    }
}