<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2018 Andrew Ying
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

namespace Jano\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Facades\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Binding of implementations to abstracts.
     *
     * @var array
     */
    protected $implementations = [
        'helper' => \Jano\Repositories\HelperRepository::class,
        \Jano\Contracts\UserContract::class => \Jano\Repositories\UserRepository::class,
        \Jano\Contracts\GroupContract::class => \Jano\Repositories\GroupRepository::class,
        \Jano\Contracts\ChargeContract::class => \Jano\Repositories\ChargeRepository::class,
        \Jano\Contracts\PaymentContract::class => \Jano\Repositories\PaymentRepository::class,
        \Jano\Contracts\TicketContract::class => \Jano\Repositories\TicketRepository::class,
        \Jano\Contracts\StaffContract::class => \Jano\Repositories\StaffRepository::class,
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
                ->link('/', __('system.home'))
                ->htmlIf(!$authenticated, '<a href="#" data-open="login-modal">'
                    . __('system.login') . __('system.slash') . __('system.register')
                    . '</a>')
                ->linkIf($authenticated, '/account', __('system.account'))
                ->htmlIf($authenticated, '<form method="post" action="' . url('logout') . '">'
                    . csrf_field() . '<button type="submit" class="clear button">'
                    . __('system.logout') . '</button></form>')
                ->setActiveFromRequest();
        });

        Menu::macro('backend', function () {
            return Menu::new()
               ->link('/admin', __('system.home'))
               ->link('/admin/users', __('system.users'))
               ->link('/admin/groups', __('system.groups'))
               ->link('/admin/attendees', __('system.attendees'))
               ->link('/admin/tickets', __('system.types'))
               ->link('/admin/payments', __('system.payments'))
               ->link('/admin/staffs', __('system.staff'))
               ->link('/admin/settings', __('system.settings'))
               ->link('/admin/about', __('system.about'))
               ->setActiveFromRequest('/admin');
        });

        Schema::defaultStringLength(191);

        $this->binding();
        $this->bindingSpecial();
    }

    /*
     * Registers the repositories used for the application.
     */
    protected function binding()
    {
        foreach ($this->implementations as $abstract => $implementation) {
            $this->app->bind($abstract, function ($app) use ($implementation) {
                return new $implementation();
            });
        }
    }

    /**
     * Register the repositories which in turn require service container resolving.
     */
    protected function bindingSpecial()
    {
        $this->app->bind(\Jano\Contracts\AttendeeContract::class, function ($app) {
            return new \Jano\Repositories\AttendeeRepository(
                $app->make(\Jano\Contracts\TicketContract::class),
                $app->make(\Jano\Contracts\ChargeContract::class)
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
