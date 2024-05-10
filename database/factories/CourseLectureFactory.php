<?php

namespace Database\Factories;

use App\Models\CourseSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseLecture>
 */
class CourseLectureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_section_id' => CourseSection::pluck('id')->random(),
            'title' => fake()->sentence(3),
            'content' => fake()->sentence(),
            'video' => fake()->url()
        ];
    }
}
