<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{


    protected function createRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:categories'],
            'image' => 'required|image:jpeg,png,jpg,gif,svg',

        ];
    }

    protected function updateRules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'min:3', 'max:255', 'unique:categories'],
            'image' => 'sometimes|image:jpeg,png,jpg,gif,svg',

        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
