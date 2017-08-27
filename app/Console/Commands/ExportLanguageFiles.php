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
use Jano\Repositories\HelperRepositories;
use Storage;

class ExportLanguageFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the language files in .json format';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        foreach (glob(resource_path('lang/en') . '/*.php') as $file) {
            $array = HelperRepositories::flattenArrayKey(require $file);

            Storage::disk('local')
                ->put('lang/' . str_replace('php', 'json', basename($file)), json_encode($array));
        }
    }
}
