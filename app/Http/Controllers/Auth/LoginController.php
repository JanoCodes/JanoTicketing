<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2018 Andrew Ying and other contributors.
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

namespace Jano\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Jano\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Kris\LaravelFormBuilder\FormBuilder;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @param \Kris\LaravelFormBuilder\FormBuilder $builder
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(FormBuilder $builder)
    {
        $form = $builder->createByArray([
            [
                'name' => 'email',
                'type' => 'email',
                'label' => __('system.email'),
                'rules' => ['required'],
                'validationMessage' => __('validation.email', ['attribute' => strtolower(__('system.email'))])
            ],
            [
                'name' => 'password',
                'type' => 'password',
                'label' => __('system.password'),
                'rules' => ['required'],
                'validationMessage' => __('validation.required', ['attribute' => strtolower(__('system.password'))])
            ],
            [
                'name' => 'remember',
                'type' => 'checkbox',
                'label' => __('system.remember_me')
            ],
            [
                'name' => 'submit',
                'type' => 'submit',
                'label' => __('system.login'),
                'wrapper' => [
                    'class' => 'col-sm-8 offset-sm-4'
                ],
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]
        ], [
            'method' => 'POST',
            'url' => route('login')
        ]);

        return view('auth.login', ['form' => $form]);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect('login')
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }
}
