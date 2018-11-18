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

use Jano\Contracts\UserContract;
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

    use RegistersUsers;

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
        $form = $builder->createByArray([
            [
                'name' => 'title',
                'type' => 'select',
                'label' => __('system.title'),
                'choices' => __('system.titles'),
                'rules' => ['required'],
                'validationMessage' => __('validation.required', ['attribute' => strtolower(__('system.title'))])
            ],
            [
                'name' => 'first_name',
                'type' => 'text',
                'label' => __('system.first_name'),
                'rules' => ['required'],
                'validationMessage' => __('validation.required', ['attribute' => strtolower(__('system.first_name'))])
            ],
            [
                'name' => 'last_name',
                'type' => 'text',
                'label' => __('system.last_name'),
                'rules' => ['required'],
                'validationMessage' => __('validation.required', ['attribute' => strtolower(__('system.last_name'))])
            ],
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
                'name' => 'password_confirmation',
                'type' => 'password',
                'label' => __('system.confirm_password'),
                'rules' => [
                    'required',
                    'confirmed'
                ]
            ],
            [
                'name' => 'submit',
                'type' => 'submit',
                'label' => __('system.register'),
                'wrapper' => [
                    'class' => 'col-sm-8 offset-sm-4'
                ],
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]
        ], [
            'method' => 'POST',
            'url' => route('register')
        ]);

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
