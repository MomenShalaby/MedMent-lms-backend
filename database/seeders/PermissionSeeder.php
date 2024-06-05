<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'category-create',
            'category-viewall',
            'category-edit',
            'category-delete',
            'subcategory-create',
            'subcategory-viewall',
            'subcategory-edit',
            'subcategory-delete',
            'course-create',
            'course-viewall',
            'course-edit',
            'course-image-edit',
            'course-delete',
            'course-sections-create',
            'course-sections-viewall',
            'course-sections-edit',
            'course-sections-delete',
            'course-lectures-create',
            'course-lectures-viewall',
            'course-lectures-edit',
            'course-lecture-image-edit',
            'course-lectures-delete',
            'event-create',
            'event-viewall',
            'event-edit',
            "event-image-edit",
            'event-delete',
            'attendee-viewall',
            'user-viewall',
            'hospital-viewall',
            'hospital-create',
            'hospital-edit',
            'hospital-delete',
            'subscription-viewall',
            'subscription-edit',
            'university-create',
            'university-edit',
            'university-delete',
            'degree-create',
            'degree-edit',
            'degree-delete',

        ];
        foreach ($permissions as $permission) {
            Permission::create(['guard_name' => 'admin', 'name' => $permission]);
        }
    }
}
