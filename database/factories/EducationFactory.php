<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Degree;
use App\Models\State;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
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
            'degree_id' => Degree::pluck('id')->random(),
            'start_date' => fake()->dateTimeBetween()->format('Y-m-d'),
            'end_date' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['start_date'], 'now')->format('Y-m-d');
            },
            'description' => fake()->text(),
            'university_id' => University::pluck('id')->random(),
            'other_university' => null,
            'country_id' => Country::pluck('id')->random(),
            'state_id' => State::pluck('id')->random(),
        ];
    }
}
