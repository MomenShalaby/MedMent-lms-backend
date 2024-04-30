<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Traits\CanLoadRelationships;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventController extends Controller
{
    use HttpResponses;

    use CanLoadRelationships;
    private array $relations = ['attendees', 'attendees.user'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->loadRelationships(Event::query());
        $events = EventResource::collection($query->paginate());
        return $this->success($events, "data is here", 200, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        $event = Event::create(
            $request->all()
        );
        $query = $this->loadRelationships($event);
        return $this->success(new EventResource($event), "data inserted", 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $query = $this->loadRelationships($event);
        $events = new EventResource($query);
        return $this->success($events, "data is here", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, Event $events)
    {
        // return $events;
        $events->update(
            $request->all()
        );
        $query = $this->loadRelationships($events);
        return $this->success($events, "data updated", 202);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $events)
    {
        $events->delete();
        // return $this->success($event, "", 204);
        return response(status: 204);
    }
}
