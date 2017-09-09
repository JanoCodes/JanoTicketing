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
use Illuminate\Validation\Factory as Validator;
use Jano\Contracts\PaymentContract;
use Jano\Http\Controllers\Controller;
use Jano\Http\Traits\RendersAjaxView;
use Jano\Models\Account;
use Jano\Models\Payment;

class PaymentController extends Controller
{
    use RendersAjaxView;

    /**
     * @var \Jano\Contracts\PaymentContract
     */
    protected $contract;

    /**
     * PaymentController constructor.
     *
     * @param \Jano\Contracts\PaymentContract $contract
     */
    public function __construct(PaymentContract $contract)
    {
        $this->middleware(['auth', 'staff']);
        $this->contract = $contract;
    }

    /**
     * Render the index page of payments.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->ajaxView(
            $request,
            'backend.payments.index',
            $this->contract->search($request->get('q'))
        );
    }

    /**
     * Renders the payment creation page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];

        if ($redirect = request('redirect')) {
            session('redirect_url', urldecode($redirect));
        }
        if ($account_id = request('account')) {
            $data['account'] = Account::where('id', $account_id)->firstOrFail();
        }

        return view('backend.payments.create', $data);
    }

    /**
     * Return the validator instance.
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function storeValidator($data)
    {
        return Validator::make($data, [
            'account' => 'exists:accounts,id',
            'amount' => 'required|integer|min:0',
            'method' => 'required|in:' . implode(
                ',',
                collect(__('system.payment_methods'))->keys()
            ),
            'reference' => 'required'
        ]);
    }

    /**
     * Validate and store the new payment instance.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function store(Request $request)
    {
        $this->storeValidator($request->all());

        $this->contract->store(
            $request->all(),
            $request->has('account') ?
                Account::where('id', $request->get('account'))->firstOrFail() : null
        );
        return redirect($request->session()->pull('redirect_url') ??
            route('backend.payments.index'));
    }

    /**
     * Return the validator instance.
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function updateValidator($data)
    {
        return Validator::make($data, [
            'account' => 'exists:accounts,id',
            'amount' => 'integer|min:0',
            'method' => 'in:' . implode(
                ',',
                collect(__('system.payment_methods'))->keys()
            )
        ]);
    }

    /**
     * Validate and update the payment instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Jano\Models\Payment $payment
     */
    public function update(Request $request, Payment $payment)
    {
        $this->updateValidator($request->all());

    }
}
