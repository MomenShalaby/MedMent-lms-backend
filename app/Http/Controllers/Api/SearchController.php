<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Event;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use HttpResponses;
    /**
     * Handle the incoming request.
     */
    public function __invoke($term)
    {
        $courses = Course::search($term)->get();
        $events = Event::search($term)->get();
        if ($courses->isEmpty() && $events->isEmpty()) {
            return $this->success('', 'no search results found');
        }
        return $this->success([
            'courses' => $courses,
            'events' => $events,
        ]);
    }
}
