<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use App\Traits\CanLoadRelationships;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class AttendeeController extends Controller
{
    use HttpResponses;
    use CanLoadRelationships;
    private array $relations = ['user'];

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $attendees = $event->attendees()->latest();
        $query = $this->loadRelationships($attendees);
        $attendees = AttendeeResource::collection($query->paginate());
        return $this->success($attendees, "data is here", 200, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        if ($event->attendees()->where('user_id', Auth::id())->exists()) {
            return $this->error('User is already assigned to this event', 400);
        }
        // return Auth::id();
        $attendee = $event->attendees()->create([
            'user_id' => Auth::id(),
        ]);
        $attendee = new AttendeeResource($attendee);
        return $this->success($attendee, "data is here", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        $this->loadRelationships($attendee);
        $attendee = new AttendeeResource($attendee);
        return $this->success($attendee, "data is here", 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, User $attendee)
    {
        $attendee = Attendee::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->first();
        // return $attendee;
        $attendee->delete();
        return response(status: 204);
    }

    public function showUserEvents()
    {
        $user_id = Auth::id();
        $events = Attendee::where('user_id', $user_id)->get();
        // $this->loadRelationships($events);
        $events = AttendeeResource::collection($events);
        return $this->success($events, "data is here", 200);
    }
}
