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

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Jano\Contracts\PaymentContract;
use League\Csv\Reader;
use Illuminate\Log\Writer as Log;
use SplFileObject;
use Illuminate\Validation\Factory as Validator;

class ImportPaymentFromFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \SplFileObject
     */
    protected $file;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $definition;

    /**
     * Create a new job instance.
     *
     * @param \SplFileObject $file
     * @param \Illuminate\Support\Collection $definition
     */
    public function __construct(SplFileObject $file, Collection $definition)
    {
        $this->file = $file;
        $this->definition = $definition;
    }

    /**
     * Execute the job.
     *
     * @param \Jano\Contracts\PaymentContract
     * @return void
     */
    public function handle(PaymentContract $contract)
    {
        $reader = Reader::createFromFileObject($this->file);
        $records = $reader->getRecords($this->definition->values());

        $success = 0;
        $fail = 0;

        foreach ($records as $record) {
            if ($this->recordValidator($record)->fails()) {
                Log::error('Payment record failed validation. Skipping...', ['record' => $record]);
                $fail++;
            } else {
                $contract->store([
                    'amount' => $record->{$this->definition['amount']},
                    'type' => 'bank_transfer',
                    'reference' => $record->{$this->definition['reference']},
                    'made_at' => Carbon::createFromTimestamp($record->{$this->definition['date']})
                ]);

                $success++;
            }
        }

        Log::info('Completed importing payments. ' . $success . ' record(s) imported successfully and '
            . $fail . ' requires further attention.');
    }

    /**
     * Return the record validator instance
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function recordValidator($data)
    {
        return Validator::make($data, [
            $this->definition['date'] => 'required|date',
            $this->definition['amount'] => 'required|numeric',
            $this->definition['reference'] => 'required'
        ]);
    }
}
