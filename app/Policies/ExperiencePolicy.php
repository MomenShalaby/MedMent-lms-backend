<?php

namespace App\Policies;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExperiencePolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Experience $experience): bool
    {
        return $experience->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Experience $experience): bool
    {
        return $experience->user_id === $user->id;
    }
}
