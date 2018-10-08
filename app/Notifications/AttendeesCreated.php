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

namespace Jano\Notifications;

use Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Jano\Models\Account;

class AttendeesCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \Jano\Models\Account
     */
    public $account;

    /**
     * @var \Illuminate\Support\Collection|\Jano\Models\Attendee
     */
    public $attendees;

    /**
     * Create a new notification instance.
     *
     * @param \Jano\Models\Account $account
     * @param \Jano\Models\Attendee|\Illuminate\Support\Collection $attendees
     */
    public function __construct(Account $account, $attendees)
    {
        $this->account = $account;
        $this->attendees = $attendees;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $amountDue = 0;
        foreach ($this->attendees as $attendee) {
            $amountDue += Helper::getUserPrice($attendee->ticket->price, $this->account->user()->first(), false);
        }

        return (new MailMessage)
            ->markdown('mail.attendees.created', [
                'notifiable' => $notifiable,
                'account' => $this->account,
                'attendees' => $this->attendees,
                'amount_due' => $amountDue
            ]);
    }
}
