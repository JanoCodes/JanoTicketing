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

namespace Jano\Modules\TransferRequest\Console\Commands;

use Illuminate\Console\Command;
use Jano\Contracts\AttendeeContract;
use Jano\Modules\TransferRequest\Contracts\RequestContract;
use Jano\Jobs\ProcessTransferRequests as Job;

class ProcessTransferRequests extends Command
{
    /**
     * @var \Jano\Contracts\AttendeeContract
     */
    protected $attendee;

    /**
     * @var \Jano\Modules\TransferRequest\Contracts\RequestContract
     */
    protected $transfer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfers:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process outstanding ticket transfer requests';

    /**
     * Create a new command instance.
     *
     * @param \Jano\Contracts\AttendeeContract $attendee
     * @param \Jano\Modules\TransferRequest\Contracts\RequestContract $transfer
     */
    public function __construct(AttendeeContract $attendee, RequestContract $transfer)
    {
        $this->attendee = $attendee;
        $this->transfer = $transfer;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Job::dispatch($this->transfer, $this->attendee);
    }
}
