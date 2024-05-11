<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSectionRequest;
use App\Http\Resources\CourseSectionResource;
use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Traits\CanLoadRelationships;

class CourseSectionController extends Controller
{
    use HttpResponses;
    use CanLoadRelationships;
    private array $relations = ['lectures',];

    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $query = $this->loadRelationships($course->sections());
        $course_sections = CourseSectionResource::collection($query->paginate());
        return $this->success($course_sections, "data is here", 200, true);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseSectionRequest $request, Course $course)
    {
        $section = $course->sections()->create($request->all());
        $query = $this->loadRelationships($section);
        return $this->success(new CourseSectionResource($query), "data inserted", 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, CourseSection $section)
    {
        // $section = $course->$section;
        // return $section;
        $this->loadRelationships($section);
        $section = new CourseSectionResource($section);
        return $this->success($section, "data is here", 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseSectionRequest $request, Course $course, CourseSection $section)
    {
        $section->update(
            $request->only(['title'])
        );
        $query = $this->loadRelationships($section);
        $section = new CourseSectionResource($query);
        return $this->success($section, "data updated", 201);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, CourseSection $section)
    {
        $section->delete();
        return response(status: 204);
    }
}
