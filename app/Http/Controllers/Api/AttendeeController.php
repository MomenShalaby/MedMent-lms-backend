<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
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
        $attendees = $event->attendees();
        $query = $this->loadRelationships($attendees);
        $attendees = AttendeeResource::collection($query->paginate());
        return $this->success($attendees, "data is here", 200, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        // $validated = $request->validate([
        //     'user_id' => 'required|exists:users',
        // ]);
        // $validated['user_id'] = Auth::id();


        // if ($event->attendees()->where('user_id', Auth::id())->exists()) {
        //     return $this->error('User is already assigned to this event', 400);
        // }
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
    public function destroy(Event $event, Attendee $attendee)
    {
        $attendee->delete();
        return response(status: 204);
    }
}
