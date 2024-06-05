<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $categories = [
        [
            'name' => "Anatomy",
            'image' => '/categories/anatomy.png'
        ],
        [
            'name' => "Cardiology",
            'image' => '/categories/cardiology.png'
        ],
        [
            'name' => "Hematology",
            'image' => '/categories/hematology.png'
        ],
        [
            'name' => "Histology",
            'image' => '/categories/histology.png'
        ],
        [
            'name' => "Medical Analysis",
            'image' => '/categories/medical_analysis.png'
        ],
        [
            'name' => "Nursing",
            'image' => '/categories/nursing.png'
        ],
        [
            'name' => "Pathology",
            'image' => '/categories/pathology.png'
        ],
        [
            'name' => "Physical Treatment",
            'image' => '/categories/physical_treatment.png'
        ],
        [
            'name' => "Physiology",
            'image' => '/categories/physiology.png'
        ],
        [
            'name' => "Radiology",
            'image' => '/categories/radiology.png'
        ]
    ];
    

    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Iterate over each category and create a new record in the database
        Category::insert($this->categories);

    }
}
