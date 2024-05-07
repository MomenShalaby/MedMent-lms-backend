<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseLectureRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'sometimes|string|max:1000',
            'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:102400'
        ];
    }

    protected function updateRules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string|max:1000',
            'video' => 'sometimes|mimetypes:video/avi,video/mpeg,video/quicktime|max:102400'

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
