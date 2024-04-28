<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\CourseImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\HttpResponses;
use App\Traits\FileUploader;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    use HttpResponses;
    use FileUploader;
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
        $validatedData = $request->validate([
            'course_name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'required|image:jpeg,png,jpg,gif,svg'
        ]);

        $course = Course::create([
            'course_name' => $validatedData['course_name'],
            'description' => $validatedData['description'],
            'user_id' => 1 // Assuming user ID is fixed for now
        ]);

        $this->uploadImage($request, $course, "course-image");

        // $image = new CourseImages;
        // $this->uploadMultipleImages($request, $course, "course");
        // $image->$request['images'];
        // return $image;
        // $image->save();
        if ($request->file('images')) {

            // foreach ($request->file('images') as $imagefile) {
            //     $image = new CourseImages;
            //     $path = $imagefile->store('/images/resource', ['disk' => 'public']);
            //     // $this->uploadImage($request, $course, "course-images", 'images');
            //     $image->course_id = $course->id;
            //     $image->url = $path;
            //     $image->course_id = $course->id;
            //     $image->save();
            // }
        }
        $course->load('images');

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
