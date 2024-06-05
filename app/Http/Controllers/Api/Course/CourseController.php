<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\CourseImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\NotifiableEvent;
use App\Traits\HttpResponses;
use App\Traits\CanLoadRelationships;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    use HttpResponses;
    use FileUploader;
    use CanLoadRelationships;
    use NotifiableEvent;
    private array $relations = ['category', 'sections', 'sections.lectures',];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->loadRelationships(Course::query());
        $courses = CourseResource::collection($query->latest()->paginate());
        return $this->success($courses, "data is here", 200, true);
    }



    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {

        $query = $this->loadRelationships($course);
        $courses = new CourseResource($query);
        return $this->success($courses, "data is here", 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $course = Course::create(
            $request->all()
        );

        $this->uploadImage($request, $course, "course");
        $query = $this->loadRelationships($course);
        return $this->success(new CourseResource($query), "data inserted", 201);

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        $course->update(
            $request->all()
        );
        $query = $this->loadRelationships($course);
        $course = new CourseResource($query);
        return $this->success($course, "data updated", 201);
    }
    public function updateCourseImage(CourseRequest $request, Course $course)
    {

        $this->deleteImage($course->image);
        $this->uploadImage($request, $course, 'course');

        return $this->success($course, "image updated", 202);

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {

        $this->deleteImage($course->image);
        $course->delete();
        return response(status: 204);
    }
}
