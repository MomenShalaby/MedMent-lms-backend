<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Attendee;
use App\Models\User;

class AttendeePolicy
{

    /**
     * Determine whether the user can view the model.
     */
    // public function view(User $user, Attendee $attendee): Response
    // {
    //     return $attendee->user_id === $user->id
    //         ? Response::allow()
    //         : Response::deny('You are not signed to this event.');
    // }


}
