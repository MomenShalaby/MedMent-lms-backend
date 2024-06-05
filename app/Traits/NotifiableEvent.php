<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\EventCreatedNotification;

trait NotifiableEvent
{
    public function notifyUsersWithSharedTags()
    {
        // Retrieve tags associated with the new event
        $newEventTags = $this->tags()->pluck('tags.id'); // Specify table name for the id column

        // Retrieve users who have the same tags as the new event
        $usersWithSameTags = User::whereHas('tags', function ($query) use ($newEventTags) {
            $query->whereIn('tags.id', $newEventTags); // Specify table name for the id column
        })->get();

        // Notify each user
        foreach ($usersWithSameTags as $user) {
            $user->notify(new EventCreatedNotification($this)); // Pass $this (event instance) to the notification
        }
    }
}
