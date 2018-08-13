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

namespace Jano\Modules\TransferRequest\Jobs;

use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Jano\Contracts\AttendeeContract;
use Jano\Modules\TransferRequest\Contracts\RequestContract;

class ProcessTransferRequests implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Jano\Modules\TransferRequest\Contracts\RequestContract
     */
    private $transferRequestContract;

    /**
     * @var \Jano\Contracts\AttendeeContract
     */
    private $attendeeContract;

    /**
     * Create a new job instance.
     *
     * @param \Jano\Modules\TransferRequest\Contracts\RequestContract $transferRequestContract
     * @param \Jano\Contracts\AttendeeContract $attendeeContract
     */
    public function __construct(RequestContract $transferRequestContract, AttendeeContract $attendeeContract)
    {
        $this->transferRequestContract = $transferRequestContract;
        $this->attendeeContract = $attendeeContract;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->transferRequestContract->getPending() as $transfer) {
            DB::beginTransaction();

            $this->attendeeContract->store(
                $transfer->primary_ticket_holder ? $transfer->newUser() : $transfer->user(),
                collect([
                    'title' => $transfer->title,
                    'first_name' => $transfer->first_name,
                    'last_name' => $transfer->last_name,
                    'email' => $transfer->email,
                    'ticket_id' => $transfer->attendee()->ticket_id,
                    'primary_ticket_holder' => $transfer->primary_ticket_holder
                ]),
                false
            );
            $transfer->attendee()->delete();

            $this->transferRequestContract->markAsProcessed($transfer);

            DB::commit();
        }
    }
}
