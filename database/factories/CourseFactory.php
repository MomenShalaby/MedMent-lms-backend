<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_name' => fake()->unique()->sentence(3),
            'course_title' => fake()->unique()->sentence(3),
            'category_id' => Category::pluck('id')->random(),

            'description' => fake()->text(),
            // 'image' => fake()->imageUrl(),
            'instructor' => fake()->name(),
            'video' => fake()->url(),
            'label' => fake()->sentence(3),
            'duration' => fake()->time('H:i'),
            'resources' => fake()->unique()->sentence(3),
            'certificate' => fake()->unique()->sentence(3),
            'prerequisites' => fake()->unique()->sentence(3),
            'featured' => fake()->unique()->sentence(3),
            'price' => fake()->numberBetween(5, 60),
            'status' => $this->faker->randomElement(['Inactive', 'Active']),
        ];
    }
}
