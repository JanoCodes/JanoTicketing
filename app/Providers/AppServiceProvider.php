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

        Validator::extend('max_sum', function ($attribute, $value, $parameters, $validator) {
            return array_sum($value) <= $parameters[0];
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
