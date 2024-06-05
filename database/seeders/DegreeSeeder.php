<?php

namespace Database\Seeders;

use App\Models\Degree;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    private $degrees = [
        [
            'name' => 'Bachelor of Medicine',
        ],
        [
            'name' => 'Master of Medicine',
        ],
        [
            'name' => 'Master of Clinical Medicine',
        ],
        [
            'name' => 'Master of Medical Science',
        ],
        [
            'name' => 'Master of Public Health',
        ],
        [
            'name' => 'Master of Surgery',
        ],
        [
            'name' => 'Doctor of Medicine',
        ],
        [
            'name' => 'Doctor of Osteopathic Medicine',
        ],
        [
            'name' => 'Doctor of Clinical Medicine',
        ],
        [
            'name' => 'Doctor of Surgery',
        ],
        [
            'name' => 'Doctor of Podiatric Medicine',
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Degree::insert($this->degrees);
    }
}
