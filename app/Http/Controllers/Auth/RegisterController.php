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

namespace Jano\Http\Controllers\Auth;

use Jano\Contracts\UserContract;
use Jano\Http\Traits\WithAuthenticationForms;
use Kris\LaravelFormBuilder\FormBuilder;
use Setting;
use Illuminate\Http\Request;
use Jano\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, WithAuthenticationForms;

    /**
     * @var \Jano\Contracts\UserContract
     */
    protected $contract;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @param \Jano\Contracts\UserContract $contract
     */
    public function __construct(UserContract $contract)
    {
        $this->middleware('guest');
        $this->contract = $contract;
    }

    /**
     * Show the application registration form.
     *
     * @param \Kris\LaravelFormBuilder\FormBuilder $builder
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(FormBuilder $builder)
    {
        $form = $this->registerForm($builder);
        return view('auth.register', ['form' => $form]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|in:' . implode(',', __('system.titles')),
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6|pwned|confirmed',
            'group_id' => 'required|exists:groups,id',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Jano\Models\User
     */
    protected function create(array $data)
    {
        return $this->contract->store($data);
    }

    /**
     * Handle a registration default for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $data = $request->all();
        $data['method'] = 'database';
        if (!isset($data['group_id'])) {
            $data['group_id'] = Setting::get('register.default_group');
        }

        $validation = $this->validator($data);

        if ($validation->failed()) {
            return redirect('register')
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors($validation->getMessageBag());
        }

        $user = $this->create($data);
        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }
}
