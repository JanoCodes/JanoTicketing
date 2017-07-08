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

namespace Jano\Providers;

use Auth;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Jano\Facades\Helper;
use Jano\Repositories\HelperRepositories;
use Laravel\Socialite\Contracts\Factory as SocialiteContract;
use Menu;
use Jano\Socialite\OauthProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \InvalidArgumentException;
     */
    public function boot()
    {
        Menu::macro('frontend', function() {
            return Menu::new()
                ->action('HomeController@index', 'Home')
                ->htmlIf(!Auth::check(), '<a href="#" data-open="login-modal">'
                    . __('system.login') . __('system.slash') . __('system.register') . '</a>')
                ->setActiveFromRequest();
        });

        Schema::defaultStringLength(191);

        $socialite = $this->app->make(SocialiteContract::class);
        $socialite->extend(
            'oauth',
            function($app) use ($socialite) {
                $config = $app['config']['services.oauth'];
                return $socialite->buildProvider(OauthProvider::class, $config);
            }
        );

        Validator::extend('sum_between', function ($attribute, $value, $parameters, $validator) {
            if (isset($parameters[2])) {
                $segments = explode('.*', $parameters[2], -1);
                if (empty($segments) && $parameters[2] !== '*') {
                    throw new InvalidArgumentException('The sum_between rule must take an array.');
                }

                $array = Helper::flattenArrayKey($validator->getData());

                $value = collect($array)->filter(function ($value, $index) use ($parameters) {
                    $regex = '/' . str_replace('*', '[^\.\n\r]+?',
                            str_replace('.', '\.', $parameters[2])) . '/';

                    return preg_match($regex, $index);
                });
            }
            elseif (is_array($value)) {
                $value = collect($value);
            }
            else {
                throw new InvalidArgumentException('The sum_between rule must take an array.');
            }

            $sum = $value->sum();
            return $sum <= $parameters[1] && $sum >= $parameters[0];
        });
        Validator::replacer('sum_between', function ($message, $attribute, $rule, $parameters) {
            $needle = array(':min', ':max');
            $value = array($parameters[0], $parameters[1]);
            return str_replace($needle, $value, $message);
        });

        $this->app->bind('helper', function($app) {
            return new HelperRepositories();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
