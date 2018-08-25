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

namespace Jano\Modules\TicketRequest\Jobs;

use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Jano\Contracts\AttendeeContract;
use Jano\Modules\TicketRequest\Contracts\RequestContract;

class ProcessTicketRequests implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Jano\Contracts\AttendeeContract
     */
    protected $attendeeContract;

    /**
     * @var \Jano\Modules\TicketRequest\Contracts\RequestContract
     */
    protected $requestContract;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $tickets;

    /**
     * Create a new job instance.
     *
     * @param \Jano\Contracts\AttendeeContract $attendeeContract
     * @param \Jano\Modules\TicketRequest\Contracts\RequestContract $requestContract
     * @param \Illuminate\Support\Collection $tickets
     */
    public function __construct(
        AttendeeContract $attendeeContract,
        RequestContract $requestContract,
        Collection $tickets
    ) {
        $this->attendeeContract = $attendeeContract;
        $this->requestContract = $requestContract;
        $this->tickets = $tickets;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->requestContract->getPending() as $request) {
            if ($this->tickets->contains($request->ticket())) {
                DB::beginTransaction();

                $this->tickets->forget($request->ticket());
                $attendee = $this->attendeeContract->store($request->user(), collect($request->toArray()));
                $this->requestContract->markAsHonoured($request, $attendee->first());

                DB::commit();
            }
        }
    }
}
