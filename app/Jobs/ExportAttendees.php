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

namespace Jano\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Jano\Contracts\AttendeeContract;
use League\Csv\Writer;
use Storage;

class ExportAttendees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Jano\Contracts\AttendeeContract
     */
    private $contract;

    /**
     * @var array
     */
    private $fields;

    /**
     * Create a new job instance.
     *
     * @param \Jano\Contracts\AttendeeContract $contract
     * @param array $fields
     */
    public function __construct(AttendeeContract $contract, array $fields = [])
    {
        $this->contract = $contract;
        $this->fields = $fields;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        $results = $this->contract->export($this->fields);
        $csv->insertAll($results);

        Storage::put('private/exports/' . time() . '.csv', $csv->getContent());
    }
}
