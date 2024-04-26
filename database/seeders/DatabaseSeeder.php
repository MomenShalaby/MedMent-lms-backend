<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,
            SubscriptionSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
        ]);

        User::factory(10)->create();

        User::factory()->create([
            'fname' => 'Test',
            'lname' => 'User',
            'email' => 'test@example.com',
        ]);
        $this->call([
            CourseSeeder::class,
            EventSeeder::class,
            AttendeeSeeder::class,
        ]);
    }
}
