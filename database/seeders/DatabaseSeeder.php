<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Experience;
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
            HospitalSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            EventSeeder::class,
            AttendeeSeeder::class,
        ]);
    }
}
