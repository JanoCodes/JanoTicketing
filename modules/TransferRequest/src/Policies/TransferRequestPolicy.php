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

namespace Jano\Modules\TransferRequest\Policies;

use Jano\Models\User;
use Jano\Modules\TransferRequest\Models\TransferRequest;
use Illuminate\Auth\Access\HandlesAuthorization;
use Setting;

class TransferRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the transfer request.
     *
     * @param  \Jano\Models\User  $user
     * @param  \Jano\Modules\TransferRequest\Models\TransferRequest  $transferRequest
     * @return mixed
     */
    public function view(User $user, TransferRequest $transferRequest)
    {
        return $user->id === $transferRequest->user_id;
    }

    /**
     * Determine whether the user can create transfer requests.
     *
     * @param  \Jano\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return ($user->attendees()->count() > 0) && Setting::get('system.transfer.open');
    }

    /**
     * Determine whether the user can update the transferRequest.
     *
     * @param  \Jano\Models\User  $user
     * @param  \Jano\Modules\TransferRequest\Models\TransferRequest  $transferRequest
     * @return mixed
     */
    public function update(User $user, TransferRequest $transferRequest)
    {
        return ($user->id === $transferRequest->user_id) && Setting::get('system.transfer.open');
    }

    /**
     * Determine whether the user can delete the transferRequest.
     *
     * @param  \Jano\Models\User  $user
     * @param  \Jano\Modules\TransferRequest\Models\TransferRequest  $transferRequest
     * @return mixed
     */
    public function delete(User $user, TransferRequest $transferRequest)
    {
        return $user->id === $transferRequest->user_id;
    }
}
