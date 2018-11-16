<?php

/**
 * Jano Ticketing System
 * Copyright (C) 2016-2018 Andrew Ying and other contributors.
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

use DNS2D;
use Illuminate\Console\Command;
use Jano\Contracts\AttendeeContract;

class GenerateQRCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendees:qr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate QR code for each attendee';

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

    public function handle()
    {
        foreach ($this->contract->export(['uuid']) as $uuid) {
            $path = DNS2D::getBarcodePNGPath($uuid[0], 'QRCODE', 10, 10);
            rename($path, public_path('barcode/' . $uuid[0] . '.png'));
        }
    }
}