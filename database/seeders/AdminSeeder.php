<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'fname' => 'super',
            'lname' => 'admin',
            'email' => 'sadmin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ])->assignRole('super_admin');
    }
}
