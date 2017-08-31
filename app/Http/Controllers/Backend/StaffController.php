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

namespace Jano\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Jano\Contracts\StaffContract;
use Jano\Http\Controllers\Controller;
use Jano\Http\Traits\RendersAjaxView;
use Jano\Models\Staff;
use Jano\Models\User;
use function redirect;
use function route;

class StaffController extends Controller
{
    use RendersAjaxView;

    /**
     * @var \Jano\Contracts\StaffContract
     */
    protected $contract;

    /**
     * StaffController constructor.
     *
     * @param \Jano\Contracts\StaffContract $contract
     */
    public function __construct(StaffContract $contract)
    {
        $this->middleware(['auth', 'staff']);
        $this->contract = $contract;
    }

    /**
     * Render the index page for staff.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->ajaxView(
            $request,
            'backend.staff.index',
            $this->contract->search($request->get('q'))
        );
    }

    /**
     * Renders the staff creation page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.staff.create');
    }

    /**
     * Return the Validator instance.
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function storeValidator($data)
    {
        return Validator::make($data, [
            'user_id' => 'required|exists:users',
            'access_level' => 'required|integer|min:1'
        ]);
    }

    /**
     * Store the newly created staff instance
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('store', \Jano\Models\Staff::class);
        $this->storeValidator($request->all());

        $this->contract->store(
            User::where('id', $request->get('user_id'))->first(),
            $request->get('access_level')
        );

        return redirect()->route('backend.staff.index');
    }

    /**
     * Render the staff edit page.
     *
     * @param \Jano\Models\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        return view('backend.staff.edit', [
            'staff' => $staff
        ]);
    }

    /**
     * Return the Validator instance.
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function updateValidator($data)
    {
        return Validator::make($data, [
            'access_level' => 'required|integer|min:1'
        ]);
    }

    /**
     * Update the parameters of the staff instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Jano\Models\Staff $staff
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Staff $staff)
    {
        $this->authorize('update', $staff);
        $this->updateValidator($request->all());

        $this->contract->update($staff, $request->get('access_level'));

        return redirect()->route('backend.staff.index');
    }

    /**
     * Destroy a staff instance.
     *
     * @param \Jano\Models\Staff $staff
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Staff $staff)
    {
        $this->authorize('destroy', $staff);
        $this->contract->destroy($staff);

        return redirect()->route('backend.staff.index');
    }
}
