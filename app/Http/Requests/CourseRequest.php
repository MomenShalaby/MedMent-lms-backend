<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    protected function createRules(): array
    {
        return [
            'course_name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|image:jpeg,png,jpg,gif,svg',
            'category_id' => 'required|exists:categories,id',
            'instructor' => 'nullable|string',
            'course_title' => 'nullable|string',
            'video' => 'nullable|string',
            'label' => 'nullable|string',
            'duration' => 'nullable|string',
            'resources' => 'nullable|string',
            'certificate' => 'nullable|string',
            'prerequisites' => 'nullable|string',
            'featured' => 'nullable|string',
            'price' => 'nullable|integer',
            'status' => 'nullable|in:inactive,active',
        ];
    }

    protected function updateRules(): array
    {
        return [
            'course_name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'image' => 'nullable|image:jpeg,png,jpg,gif,svg',
            'category_id' => 'sometimes|exists:categories,id',
            'instructor' => 'sometimes|string',
            'course_title' => 'sometimes|string',
            'video' => 'sometimes|string',
            'label' => 'sometimes|string',
            'duration' => 'sometimes|string',
            'resources' => 'sometimes|string',
            'certificate' => 'sometimes|string',
            'prerequisites' => 'sometimes|string',
            'featured' => 'sometimes|string',
            'status' => 'sometimes|in:Inactive,Active',
        ];
    }





    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->updateRules();
        }
        return $this->createRules();
    }
}
