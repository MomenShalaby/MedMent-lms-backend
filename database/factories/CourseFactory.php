<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

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

        $imagePath = public_path('courses-pic');
        $images = File::allFiles($imagePath);
        $image = $images[rand(0, count($images) - 1)]->getRelativePathname();

        return [
            'course_name' => fake()->unique()->sentence(3),
            'course_title' => fake()->unique()->sentence(3),
            'category_id' => Category::pluck('id')->random(),
            'description' => fake()->text(),
            'image' => "/courses-pic/".$image, // Assign the selected image path
            'instructor' => "Mahmoud El-Basha",
            'video' => "https://www.youtube.com/embed/mzPu7q6GNQA?si=JZTIjzdMxgyrvK6x",
            'label' => fake()->sentence(3),
            'duration' => fake()->time('H:i'),
            'resources' => fake()->unique()->sentence(3),
            'certificate' => fake()->unique()->sentence(3),
            'prerequisites' => fake()->unique()->sentence(3),
            'featured' => fake()->unique()->sentence(3),
            'price' => fake()->numberBetween(5, 60),
            'status' => $this->faker->randomElement(['inactive', 'active']),
        ];
    }
}
