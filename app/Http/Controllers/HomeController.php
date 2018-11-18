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

namespace Jano\Http\Controllers;

use Carbon\Carbon;
use Kris\LaravelFormBuilder\FormBuilder;
use Setting;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param \Kris\LaravelFormBuilder\FormBuilder $builder
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $builder)
    {
        $login = $builder->createByArray([
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

        $register = $builder->createByArray([
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

        $event_date = [
            'from' => Carbon::parse(Setting::get('event.date.from')),
            'to' => Carbon::parse(Setting::get('event.date.to'))
        ];

        return view('home', [
            'event_date' => $event_date,
            'login' => $login,
            'register' => $register
        ]);
    }
}
