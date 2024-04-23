<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        for ($i = 0; $i < 200; $i++) {
            $user = $users->random();
            Course::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }
}
