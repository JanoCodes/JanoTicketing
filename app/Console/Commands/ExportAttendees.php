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

namespace Jano\Console\Commands;

use Illuminate\Console\Command;
use Jano\Contracts\AttendeeContract;
use Jano\Jobs\ExportAttendees as Job;

class ExportAttendees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendees:export {fields*? : the fields to be included}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export list of attendees as a CSV file';

    /**
     * @var \Jano\Contracts\AttendeeContract
     */
    private $contract;

    /**
     * Create a new command instance.
     *
     * @param \Jano\Contracts\AttendeeContract $contract
     */
    public function __construct(AttendeeContract $contract)
    {
        $this->contract = $contract;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $fields = $this->argument('fields');

        if ($fields) {
            Job::dispatch($this->contract, $fields);
        } else {
            Job::dispatch($this->contract);
        }
    }
}
