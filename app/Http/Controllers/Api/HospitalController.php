<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospitals = Hospital::all();
        return $this->success([
            'hospitals' => $hospitals,
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

        $hospital = Hospital::create([
            'name' => $request->name,
        ]);

        return $this->success(
            [
                "hospital" => $hospital,
            ],
            'Hospital created successfully',
            201
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hospital $hospital)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
        ]);

        $hospital->update([
            'name' => $request->name,
        ]);

        return $this->success(
            [
                "hospital" => $hospital,
            ],
            'Hospital updated successfully',
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hospital $hospital)
    {
        $hospital->delete();
        return $this->success('', 'Hospital Deleted Successfully');
    }
}
