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
            'course-delete',
            'event-create',
            'event-viewall',
            'event-edit',
            'event-delete',
            'attendee-viewall',
            'news-create',
            'news-viewall',
            'news-edit',
            'news-delete',
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
