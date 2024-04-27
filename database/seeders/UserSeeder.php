<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create()->each(function ($user) {
            $numberOfExperiences = random_int(0, 3);
            Experience::factory($numberOfExperiences)->for($user)->create();
        });

        User::factory()->create([
            'fname' => 'Test',
            'lname' => 'User',
            'email' => 'test@example.com',
        ]);
    }
}
