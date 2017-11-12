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

namespace Jano\Http\Controllers\Backend;

use Artisan;
use Illuminate\Http\Request;
use Jano\Http\Controllers\Controller;
use Validator;

class JobController extends Controller
{
    /**
     * Validate job attributes.
     *
     * @param $data
     * @return \Illuminate\Support\Facades\Validator
     */
    private function validateJob($data)
    {
        return Validator::make($data, [
            'type' => 'in:command'
        ]);
    }

    /**
     * Handle request to dispatch job.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateJob($request->all());

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        switch ($request->post('type')) {
            case 'command':
                $command = $request->post('command');

                if (($matches = preg_match('/[a-z0-9\-_]+(:[a-z0-9\-_]+)?/', $command))
                    && ($matches[0] === $command)) {
                    Artisan::run($request->post('command'));
                } else {
                    abort(500);
                }

                break;
        }

        return redirect()
            ->back()
            ->with('success', __('system.job_successfully_queued'));
    }
}
