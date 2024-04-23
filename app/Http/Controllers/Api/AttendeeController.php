<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class AttendeeController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        // return Attendee::all();

        $attendees = $event->attendees();
        $attendees = AttendeeResource::collection($attendees->paginate());
        return $this->success($attendees, "data is here", 200, true);
        // return $attendees->where()
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $attendee = $event->attendees()->create([
            'user_id' => 1,
        ]);
        $attendee = new AttendeeResource($attendee);
        return $this->success($attendee, "data is here", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {

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
