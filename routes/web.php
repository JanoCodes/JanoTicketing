<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2017 Andrew Ying
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

use Illuminate\Routing\Router as Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('event', 'EventController@show');
Route::get('account', 'AccountController@view')->name('accounts.view');
Route::resource('attendees', 'AttendeeController', ['except' => ['list', 'view']]);
Route::resource('requests', 'TicketRequestController');
Route::resource('transfers', 'TransferRequestController');
Route::get('transfers/{transfer}/confirm/{token}', 'ConfirmedTransferRequestController@store')
    ->name('transfers.confirm');
Route::get('transfers/{transfer}/associate', 'ConfirmedTransferRequestController@update')
    ->name('transfers.associate');

Route::group([
    'namespace' => 'Backend',
    'prefix' => 'admin',
    'as' => 'backend.'
], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('about', 'HomeController@about')->name('about');
    Route::resource('users', 'UserController');
    Route::resource('attendees', 'AttendeeController');
    Route::resource('collections', 'CollectionController');
    Route::get('payments/import', 'PaymentImportController@create')->name('paymentimports.create');
    Route::post('payments/import', 'PaymentImportController@store')->name('paymentimports.store');
    Route::put('payments/import', 'PaymentImportController@update')->name('paymentimports.update');
    Route::resource('payments', 'PaymentController');
    Route::resource('requests', 'TicketRequestController');
    Route::resource('staff', 'StaffController');
    Route::resource('transfers', 'TransferRequestController');
    Route::get('settings', 'SettingController@index')->name('settings.index');
    Route::put('settings', 'SettingController@update')->name('settings.update');
});

Route::auth();
Route::get('login/oauth', 'Auth\LoginController@redirectToProvider')->name('oauth.login');
Route::get('login/oauth/callback', 'Auth\LoginController@handleProviderCallback')->name('oauth.callback');
