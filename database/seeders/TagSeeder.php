<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{

    private $tags = [
        ['name' => "Anatomy"],
        ['name' => "Cardiology"],
        ['name' => "Hematology"],
        ['name' => "Histology"],
        ['name' => "Medical Analysis"],
        ['name' => "Nursing"],
        ['name' => "Pathology"],
        ['name' => "Physical Treatment"],
        ['name' => "Physiology"],
        ['name' => "Radiology"]
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tag::factory(10)->create();
        Tag::insert($this->tags);

    }
}
