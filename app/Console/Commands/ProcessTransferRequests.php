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

namespace Jano\Console\Commands;

use Illuminate\Console\Command;
use Jano\Contracts\AttendeeContract;
use Jano\Contracts\TransferRequestContract;
use Jano\Models\TransferRequest;

class ProcessTransferRequests extends Command
{
    /**
     * @var \Jano\Contracts\AttendeeContract
     */
    protected $attendee;

    /**
     * @var \Jano\Contracts\TransferRequestContract
     */
    protected $transfer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:process';

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
     * @param \Jano\Contracts\TransferRequestContract $transfer
     */
    public function __construct(AttendeeContract $attendee, TransferRequestContract $transfer)
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
        $transfers = $this->transfer->getPending();

        foreach ($transfers as $transfer) {
            $old_attendee = $transfer->attendee();

            $new_attendee = $this->attendee->store($transfer->user(), $old_attendee->ticket(), collect([
                'title' => $transfer->title,
                'first_name' => $transfer->first_name,
                'last_name' => $transfer->last_name
            ]));
            $this->transfer->associateNew($new_attendee);

            $this->transfer->process($transfer);
        }
    }
}
