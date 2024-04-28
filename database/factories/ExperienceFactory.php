<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Hospital;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'title' => fake()->sentence(),
            'start_date' => fake()->dateTimeBetween()->format('Y-m-d'),
            'end_date' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['start_date'], 'now')->format('Y-m-d');
            },
            'description' => fake()->text(),
            'hospital_id' => Hospital::pluck('id')->random(),
            'otherHospital' => null,
            'country_id' => Country::pluck('id')->random(),
            'state_id' => State::pluck('id')->random(),
        ];
    }
}
