<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserExperienceController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $experiences = $user->experiences;
        $this->success([
            "experiences" => $experiences
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:2'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'description' => ['sometimes', 'string', 'min:10'],
            'hospital_id' => ['required_without:otherHospital', 'prohibits:otherHospital', 'exists:hospitals,id'],
            'otherHospital' => ['required_without:hospital_id', 'prohibits:hospital_id'],
            'country_id' => ['required', 'exists:countries,id'],
            'state_id' => ['required', 'exists:states,id'],
        ]);
        $validated['user_id'] = Auth::id();
        $experience = Experience::create($validated);
        return $this->success([
            'experience' => $experience
        ], 'Experience added successfully');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'min:2'],
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['sometimes', 'date', 'after:start_date'],
            'description' => ['sometimes', 'string', 'min:10'],
            'hospital_id' => ['sometimes', 'prohibits:otherHospital', 'exists:hospitals,id'],
            'otherHospital' => ['sometimes', 'prohibits:hospital_id'],
            'country_id' => ['sometimes', 'exists:countries,id'],
            'state_id' => ['sometimes', 'exists:states,id'],
        ]);
        $validated['user_id'] = Auth::id();
        return $validated;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
