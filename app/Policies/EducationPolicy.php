<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EducationPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Education $education): Response
    {
        return $education->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not own this education.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Education $education): Response
    {
        return $education->user_id === $user->id
            ? Response::allow()
            : Response::deny('You do not own this education.');
    }
}
