<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    private $universities = [
        [
            "name" => "Arab Academy for Science &amp; Technology",
        ],
        [
            "name" => "Akhbar El Yom Academy",
        ],
        [
            "name" => "Alexandria University",
        ],
        [
            "name" => "Arab Open University",
        ],
        [
            "name" => "American University in Cairo",
        ],
        [
            "name" => "Assiut University",
        ],
        [
            "name" => "Al Azhar University",
        ],
        [
            "name" => "Beni Suef University",
        ],
        [
            "name" => "Benha University",
        ],
        [
            "name" => "Cairo University",
        ],
        [
            "name" => "Damanhour University",
        ],
        [
            "name" => "Damietta University",
        ],
        [
            "name" => "El Shorouk Academy",
        ],
        [
            "name" => "Fayoum University",
        ],
        [
            "name" => "Future University",
        ],
        [
            "name" => "German University in Cairo",
        ],
        [
            "name" => "Helwan University",
        ],
        [
            "name" => "Higher Technological Institute",
        ],
        [
            "name" => "Kafr El-Sheikh University",
        ],
        [
            "name" => "Mansoura University",
        ],
        [
            "name" => "Menoufia University",
        ],
        [
            "name" => "Minia University",
        ],
        [
            "name" => "Misr International University",
        ],
        [
            "name" => "Modern Acadmy",
        ],
        [
            "name" => "Modern Sciences &amp; Arts University",
        ],
        [
            "name" => "Military Technical College",
        ],
        [
            "name" => "Modern University For Technology and Information",
        ],
        [
            "name" => "Misr University for Sience and Technology",
        ],
        [
            "name" => "Nile University",
        ],
        [
            "name" => "October 6 university",
        ],
        [
            "name" => "Pharos International University",
        ],
        [
            "name" => "Sadat Academy for Management Sciences",
        ],
        [
            "name" => "Ain Shams University",
        ],
        [
            "name" => "Sohag University",
        ],
        [
            "name" => "Sinai University",
        ],
        [
            "name" => "Suez Canal University",
        ],
        [
            "name" => "South Valley University",
        ],
        [
            "name" => "Tanta University",
        ],
        [
            "name" => "Zagazig University",
        ],

    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        University::insert($this->universities);
    }
}
