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
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory as SocialiteContract;
use Menu;
use Jano\Socialite\OauthProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Binding of implementations to abstracts.
     *
     * @var array
     */
    protected $binding = [
        'helper' => \Jano\Repositories\HelperRepositories::class,
        \Jano\Contracts\UserContract::class => \Jano\Repositories\UserRepository::class,
        \Jano\Contracts\ChargeContract::class => \Jano\Repositories\ChargeRepository::class,
        \Jano\Contracts\PaymentContract::class => \Jano\Repositories\PaymentRepository::class,
        \Jano\Contracts\TicketContract::class => \Jano\Repositories\TicketRepository::class,
        \Jano\Contracts\AttendeeContract::class => \Jano\Repositories\AttendeeRepository::class,
        \Jano\Contracts\TicketRequestContract::class => \Jano\Repositories\TicketRequestRepository::class,
        \Jano\Contracts\TransferRequestContract::class => \Jano\Repositories\TransferRequestRepository::class,
        \Jano\Contracts\CollectionContract::class => \Jano\Repositories\CollectionRepository::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Menu::macro('frontend', function () {
            $authenticated = Auth::check();

            return Menu::new()
                ->action('HomeController@index', __('system.home'))
                ->htmlIf(!$authenticated, '<a href="#" data-open="login-modal">'
                    . __('system.login') . __('system.slash') . __('system.register') . '</a>')
                ->htmlIf($authenticated, '<form method="post" action="logout">' . csrf_field()
                    . '<button type="submit" class="clear button">' . __('system.logout') . '</button></form>')
                ->setActiveFromRequest();
        });

        Menu::macro('backend', function () {
            return Menu::new()
               ->action('Backend\HomeController@index', __('system.home'))
               ->setActiveFromRequest();
        });

        Schema::defaultStringLength(191);

        $socialite = $this->app->make(SocialiteContract::class);
        $socialite->extend(
            'oauth',
            function ($app) use ($socialite) {
                $config = $app['config']['services.oauth'];
                return $socialite->buildProvider(OauthProvider::class, $config);
            }
        );

        $this->binding();
    }

    /*
     * Registers the repositories used for the application.
     */
    protected function binding()
    {
        foreach ($this->binding as $abstract => $implementation) {
            $this->app->bind($abstract, function ($app) use (&$implementation) {
                return new $implementation();
            });
        }
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
