<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\User;
use App\Traits\CanLoadRelationships;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    use HttpResponses;
    use CanLoadRelationships;
    private $relations = ['user', 'degree', 'university', 'country', 'state'];

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $education = $this->loadRelationships($user->education());
        return $this->success([
            "education" => $education->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree_id' => ['required', 'exists:degrees,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'description' => ['sometimes', 'string', 'min:10'],
            'university_id' => ['required_without:other_university', 'prohibits:other_university', 'exists:universities,id'],
            'other_university' => ['required_without:university_id', 'prohibits:university_id'],
            'country_id' => ['required', 'exists:countries,id'],
            'state_id' => ['required', 'exists:states,id'],
        ]);
        $validated['user_id'] = Auth::id();
        $education = Education::create($validated);
        return $this->success([
            'education' => $education
        ], 'Education added successfully', 201);

    }
    public function storeAll(Request $request)
    {
        $validated = $request->validate([
            'education' => ['required', 'array'],
            'education.*.degree_id' => ['required', 'exists:degrees,id'],
            'education.*.start_date' => ['required', 'date'],
            'education.*.end_date' => ['required', 'date', 'after:start_date'],
            'education.*.description' => ['sometimes', 'string', 'min:10'],
            'education.*.university_id' => ['required_without:education.*.other_university', 'prohibits:education.*.other_university', 'exists:universities,id'],
            'education.*.other_university' => ['required_without:education.*.university_id', 'prohibits:education.*.university_id'],
            'education.*.country_id' => ['required', 'exists:countries,id'],
            'education.*.state_id' => ['required', 'exists:states,id'],
        ]);
        foreach ($validated['education'] as $education) {
            $education['user_id'] = Auth::id();
            Education::create($education);
        }
        return $this->success('', 'Education added successfully', 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'degree_id' => ['required_without_all:start_date,end_date,description,university_id,other_university,country_id,state_id', 'exists:degrees,id'],
            'start_date' => ['required_without_all:degree_id,end_date,description,university_id,other_university,country_id,state_id', 'date'],
            'end_date' => ['required_without_all:start_date,degree_id,description,university_id,other_university,country_id,state_id', 'date', 'after:start_date'],
            'description' => ['required_without_all:start_date,end_date,degree_id,university_id,other_university,country_id,state_id', 'string', 'min:10'],
            'university_id' => ['required_without_all:start_date,end_date,description,degree_id,other_university,country_id,state_id', 'prohibits:other_university', 'exists:universities,id'],
            'other_university' => ['required_without_all:start_date,end_date,description,university_id,degree_id,country_id,state_id', 'prohibits:university_id'],
            'country_id' => ['required_without_all:start_date,end_date,description,university_id,other_university,degree_id,state_id', 'exists:countries,id'],
            'state_id' => ['required_without_all:start_date,end_date,description,university_id,other_university,country_id,degree_id', 'exists:states,id'],
        ]);
        $validated['user_id'] = Auth::id();
        $education->update($validated);
        return $this->success([
            'education' => $education
        ], 'Education updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        $education->delete();
        return $this->success('', 'Education Deleted Successfully');
    }
}
