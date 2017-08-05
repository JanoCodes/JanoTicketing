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

namespace Jano\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Jano\Models\TransferRequest;
use Jano\Models\User;

class TransferRequestProcessed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var \Jano\Models\User
     */
    public $user;

    /**
     * @var \Jano\Models\TransferRequest
     */
    public $request;

    /**
     * Create a new message instance.
     *
     * @param \Jano\Models\User $user
     * @param \Jano\Models\TransferRequest $request
     */
    public function __construct(User $user, TransferRequest $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user)
            ->markdown('emails.transfers.processed');
    }
}
