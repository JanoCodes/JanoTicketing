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

namespace Jano\Http\Controllers\Auth;

use Setting;
use Illuminate\Http\Request;
use Jano\Models\User;
use Jano\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Socialite\Two\User as SocialiteUser;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'title' => 'required|max:20',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
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
        return User::create($data);
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

    /**
     * Create a new user instance after OAuth authentication.
     *
     * @param \Laravel\Socialite\Two\User $user
     * @return \Jano\Models\User
     */
    public function oauthCreate(SocialiteUser $user)
    {
        $raw = $user->getRaw();

        $name = $user->getName();
        $parts = explode(' ', $name);
        $lastname = array_pop($parts);
        $firstname = implode(' ', $parts);

        return $this->create([
            'first_name' => $firstname,
            'last_name' => $lastname,
            'email' => $user->getEmail(),
            'method' => 'oauth',
            'oauth_id' => $user->getId(),
            'group_id' => $raw['group']->id,
            'right_to_buy' => $raw['group']->right_to_buy,
            'guaranteed_addon' => $raw['group']->guaranteed_addon,
        ]);
    }
}
