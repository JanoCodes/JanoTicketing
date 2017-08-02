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

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned()->unique();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->string('description');
            $table->integer('amount');
            $table->dateTime('due_at')->nullable();
            $table->boolean('paid');
            $table->timestamps();
        });
        Schema::table('attendees', function (Blueprint $table) {
            $table->foreign('charge_id')->references('id')->on('charges');
        });
        Schema::table('transfer_requests', function (Blueprint $table) {
            $table->foreign('charge_id')->references('id')->on('charges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendees', function (Blueprint $table) {
            $table->dropForeign(['charge_id']);
        });
        Schema::table('transfer_requests', function (Blueprint $table) {
            $table->dropForeign(['charge_id']);
        });
        Schema::dropIfExists('charges');
    }
}
