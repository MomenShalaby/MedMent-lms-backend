<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Traits\CanLoadRelationships;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class EventController extends Controller
{
    use HttpResponses;

    use CanLoadRelationships;
    private array $relations = ['user', 'attendees', 'attendees.user'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $query = $this->loadRelationships(Event::query());

        // return EventResource::collection(
        //     $query->latest()->paginate()
        // );

        // $query = $this->loadRelationships(Event::query());
        $query = Event::when(true, fn($q) => $q->with('user','attendees', 'attendees.user'));
        $events = EventResource::collection($query->paginate());
        return $this->success($events, "data is here", 200, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => "required|date",
                'end_date' => "required|date|after:start_date"
            ]),
            'user_id' => 1
        ]);
        $event = new EventResource($event);
        return $this->success($event, "data inserted", 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('user', 'attendees');
        $event = new EventResource($event);
        return $this->success($event, "data is here", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $event->update([
            ...$request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'start_date' => "sometimes|date",
                'end_date' => "sometimes|date|after:start_date"
            ]),
        ]);

        return $this->success($event, "data updated", 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        // return $this->success($event, "", 204);
        return response(status: 204);
    }
}
