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

use Illuminate\Console\Command;
use Jano\Contracts\GroupContract;

class CreateGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'group:create
        {name : Display name of the group}
        {slug : Slug of the group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new group';

    /**
     * @var \Jano\Contracts\GroupContract
     */
    private $contract;

    /**
     * Create a new command instance.
     *
     * @param \Jano\Contracts\GroupContract $contract
     * @return void
     */
    public function __construct(GroupContract $contract)
    {
        $this->contract = $contract;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $group = array();
        $group['name'] = $this->argument('name');
        $group['slug'] = $this->argument('slug');
        $group['ticket_limit'] = $this->ask('Ticket Limit');

        $this->contract->store($group);

        $this->info('Successfully created new group.');
    }
}
