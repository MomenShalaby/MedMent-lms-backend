<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $universities = University::all();
        return $this->success([
            'universities' => $universities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
        ]);

        $university = University::create([
            'name' => $request->name,
        ]);

        return $this->success(
            [
                "university" => $university,
            ],
            'University created successfully',
            201
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, University $university)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
        ]);

        $university->update([
            'name' => $request->name,
        ]);

        return $this->success(
            [
                "university" => $university,
            ],
            'University updated successfully',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(University $university)
    {
        $university->delete();
        return $this->success('', 'University Deleted Successfully');
    }
}
