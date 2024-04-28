<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['guard_name' => 'admin', 'name' => 'super_admin'])->syncPermissions(Permission::all());
        // Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        Role::create(['name' => 'user']);
    }
}
