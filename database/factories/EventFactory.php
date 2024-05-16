<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
 
        $imagePath = public_path('events-pic');
        $images = File::allFiles($imagePath);
        $image = $images[rand(0, count($images) - 1)]->getRelativePathname();

        return [
            'name' => fake()->unique()->sentence(3),
            'description' => fake()->text(),
            'short_description' => fake()->sentence(7),
            'image' => "/events-pic/".$image, // Assign the selected image path
            'start_date' => fake()->dateTimeBetween('now', '+1 month'),
            'end_date' => fake()->dateTimeBetween('+1 month', '+2 month'),
        ];
    }
}
