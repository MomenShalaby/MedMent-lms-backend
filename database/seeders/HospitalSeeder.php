<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    private $hospitals = [
        [
            'name' => 'Ain Shams Specialized Hospital',
        ],
        [
            'name' => 'Anglo American Hospital',
        ],
        [
            'name' => 'Arab Contractor Hospital',
        ],
        [
            'name' => 'Behman Hospital',
        ],
        [
            'name' => 'Cairo Medical Hospital',
        ],
        [
            'name' => 'Cardiac Center',
        ],
        [
            'name' => 'Cleopatra Hospital',
        ],
        [
            'name' => 'Damascus Hospital',
        ],
        [
            'name' => 'Dar El Fouad Hospital',
        ],
        [
            'name' => 'Dar El Fouad Hospital',
        ],
        [
            'name' => 'Degla Medical Center',
        ],
        [
            'name' => 'Wadi Elneel Hospital',
        ],
        [
            'name' => 'El Safa Hospital',
        ],
        [
            'name' => 'El Nozha International Hospital',
        ],
        [
            'name' => 'El Salam Mohandesin Hospital',
        ],
        [
            'name' => 'El Salam International Hospital',
        ],
        [
            'name' => 'Hayat Medical Center',
        ],
        [
            'name' => 'Ibn Sina Hospital',
        ],
        [
            'name' => 'Kasr El Aini Teaching Hospital',
        ],
        [
            'name' => 'Kids Hospital',
        ],
        [
            'name' => 'Maadi Dental Center',
        ],
        [
            'name' => 'Alex-Sydeny-Kiel (ASK) Hospital',
        ],
        [
            'name' => 'Andalusia Hospital Smouha',
        ],
        [
            'name' => 'New Al-Salama Hospital',
        ],
        [
            'name' => 'Sharm El Sheikh New Hospital',
        ],
        [
            'name' => 'Sharm El Sheikh Public Hospital',
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hospital::insert($this->hospitals);
    }
}
