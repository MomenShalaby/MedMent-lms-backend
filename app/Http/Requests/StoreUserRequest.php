<?php

namespace App\Http\Requests;

use App\Enums\Enums\Gender;
use App\Enums\Enums\SubscriptionType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
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
        return [
            'fname' => ['required', 'string', 'max:30'],
            'lname' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'gender' => ['required', Rule::enum(Gender::class)],
            // 'subscription_id' => ['required', 'exists:subscriptions,id'],
            'country_id' => ['sometimes', 'exists:countries,id'],
            'state_id' => ['sometimes', 'exists:states,id'],
            'bio' => ['sometimes', 'string'],
        ];
    }
}
