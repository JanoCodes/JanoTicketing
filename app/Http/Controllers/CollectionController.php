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

namespace Jano\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validator;
use Jano\Contracts\CollectionContract;
use Jano\Models\Collection;

class CollectionController extends Controller
{
    /**
     * @var \Jano\Contracts\CollectionContract
     */
    protected $contract;

    /**
     * CollectionController constructor.
     *
     * @param \Jano\Contracts\CollectionContract $contract
     */
    public function __construct(CollectionContract $contract)
    {
        $this->middleware(['auth']);
        $this->contract = $contract;
    }

    /**
     * Renders the proxy appointment form.
     *
     * @param \Jano\Models\Collection $collection
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Collection $collection)
    {
        $this->authorize('update', $collection);

        return view('collections.edit', [
            'collection' => $collection
        ]);
    }

    /**
     * Validate the input data.
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function validate($data)
    {
        return Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email'
        ]);
    }

    /**
     * Update the details of the proxy.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Jano\Models\Collection $collection
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Collection $collection)
    {
        $this->authorize('update', $collection);

        $this->validate($request->all());
        $this->contract->update($collection, $request->all());

        return redirect(route('attendees.index'));
    }
}