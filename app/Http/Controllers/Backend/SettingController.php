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

use Illuminate\Http\Request;
use Jano\Http\Controllers\Controller;
use Jano\Repositories\HelperRepository as Helper;
use Setting;
use Validator;

class SettingController extends Controller
{
    /**
     * List of fields available in the setting file.
     *
     * @var array
     */
    protected $fields = ['system.name', 'payment.currency', 'payment.deadline'];

    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'staff']);
    }

    /**
     * Renders the index page of settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.settings.index');
    }

    /**
     * Return the validator instance.
     *
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    protected function updateValidator($data)
    {
        return Validator::make($data, [
            'system.name' => 'required',
            'payment.currency' => 'required',
            'payment.deadline' => 'required|integer|min:0'
        ]);
    }

    /**
     * Update the system settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = Helper::flattenArrayKey($request->all());
        $this->updateValidator($data);

        foreach ($data as $param => $value) {
            if (in_array($param, $this->fields, true)) {
                Setting::set($param, $value);
            }
        }

        Setting::save();

        return redirect(route('backend.settings.index'));
    }
}
