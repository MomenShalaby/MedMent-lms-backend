<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $degree = Degree::all();
        return $this->success([
            'degree' => $degree,
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

        $degree = Degree::create([
            'name' => $request->name,
        ]);

        return $this->success(
            [
                "degree" => $degree,
            ],
            'Degree created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Degree $degree)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
        ]);

        $degree->update([
            'name' => $request->name,
        ]);

        return $this->success(
            [
                "degree" => $degree,
            ],
            'Degree updated successfully',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Degree $degree)
    {
        $degree->delete();
        return $this->success('', 'Degree Deleted Successfully');
    }
}
