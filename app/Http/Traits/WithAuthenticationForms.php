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

namespace Jano\Http\Traits;

use Kris\LaravelFormBuilder\FormBuilder;

trait WithAuthenticationForms
{
    /**
     * Generate the login form.
     *
     * @param \Kris\LaravelFormBuilder\FormBuilder $builder
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function loginForm(FormBuilder $builder)
    {
        return $builder->createByArray(
            [
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
            ],
            [
                'method' => 'POST',
                'url' => route('login')
            ]
        );
    }

    /**
     * Generate the registration form.
     *
     * @param \Kris\LaravelFormBuilder\FormBuilder $builder
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function registerForm(FormBuilder $builder)
    {
        return $builder->createByArray(
            [
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
            ],
            [
                'method' => 'POST',
                'url' => route('register')
            ]
        );
    }
}
