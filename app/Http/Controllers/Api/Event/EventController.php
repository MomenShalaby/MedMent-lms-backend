<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Traits\NotifiableEvent;
use App\Traits\HttpResponses;
use App\Traits\CanLoadRelationships;
use App\Traits\FileUploader;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    use HttpResponses;
    use FileUploader;
    use CanLoadRelationships;
    use NotifiableEvent;
    private array $relations = ['attendees', 'attendees.user', 'tags'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->loadRelationships(Event::query());
        $events = EventResource::collection($query->latest()->paginate());
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
        $event->tags()->sync((array) $request->input('tag'));
        $this->uploadImage($request, $event, 'event');
        $event->notifyUsersWithSharedTags();


        $query = $this->loadRelationships($event);
        return $this->success(new EventResource($query), "data inserted", 201);

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
        $events->tags()->sync((array) $request->input('tag'));
        $query = $this->loadRelationships($events);
        $events = new EventResource($query);
        return $this->success($events, "data updated", 202);

    }

    /**
     * Update the specified resource image in storage.
     */
    public function updateEventImage(EventRequest $request, Event $events)
    {

        $this->deleteImage($events->image);
        $this->uploadImage($request, $events, 'event');

        return $this->success($events, "image updated", 202);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $events)
    {
        $this->deleteImage($events->image);
        $events->delete();
        return response(status: 204);
    }
}
