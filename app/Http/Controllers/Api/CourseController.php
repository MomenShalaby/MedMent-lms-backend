<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class CourseController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = CourseResource::collection(Course::with('user')->paginate());
        return $this->success($courses, "data is here", 200, true);
    }



    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {

        $course->load('user');
        $course = new CourseResource($course);
        return $this->success($course, "data is here", 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $course = Course::create([
            ...$request->validate([
                'course_name' => 'required|max:255',
                'description' => 'nullable',
            ]),
            'user_id' => 1
        ]);
        $course = new CourseResource($course);
        return $this->success($course, "data inserted", 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $course->update([
            ...$request->validate([
                'course_name' => 'sometimes|string|max:255',
                'description' => 'sometimes|nullable|string',
            ]),
        ]);

        return $this->success($course, "data updated", 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        // return $this->success($course, "", 204);
        return response(status: 204);
    }
}
