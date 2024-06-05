<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Experience;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CourseLectureFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            TagSeeder::class,
            SubscriptionSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            HospitalSeeder::class,
            UniversitySeeder::class,
            DegreeSeeder::class,
            SubscriptionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            CourseSeeder::class,
            CourseSectionSeeder::class,
            CourseLectureSeeder::class,
            EventSeeder::class,
            AttendeeSeeder::class,
        ]);
    }
}
