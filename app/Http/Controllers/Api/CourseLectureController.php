<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseLectureRequest;
use App\Http\Resources\CourseSectionLectureResource;
use App\Models\Course;
use App\Models\CourseLecture;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Traits\HttpResponses;
use App\Traits\CanLoadRelationships;

class CourseLectureController extends Controller
{
    use HttpResponses;
    use FileUploader;

    use CanLoadRelationships;

    /**
     * Display a listing of the resource.
     */
    public function index(Course $course, CourseSection $section)
    {
        $query = $section->lectures();
        $course_lectures = CourseSectionLectureResource::collection($query->paginate());
        return $this->success($course_lectures, "data is here", 200, true);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseLectureRequest $request, Course $course, CourseSection $section)
    {
        $lecture = $section->lectures()->create($request->all());
        $this->uploadFile($request, $lecture, 'course-lecture', 'video');
        // return $lecture;F
        return $this->success(new CourseSectionLectureResource($lecture), "data inserted", 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, CourseSection $section, CourseLecture $lecture)
    {
        // $this->loadRelationships($section);
        $lecture = new CourseSectionLectureResource($lecture);
        return $this->success($lecture, "data is here", 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseLectureRequest $request, Course $course, CourseSection $section, CourseLecture $lecture)
    {
        $lecture->update(
            $request->only(['title', 'content', 'video'])
        );
        $lecture = new CourseSectionLectureResource($lecture);
        return $this->success($lecture, "data updated", 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, CourseSection $section, CourseLecture $lecture)
    {
        $this->deleteFile($lecture->video);
        return $lecture->video;
        $lecture->delete();
        return response(status: 204);
    }
}
