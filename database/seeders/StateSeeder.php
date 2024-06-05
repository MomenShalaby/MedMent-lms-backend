<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statesJson = Storage::disk('local')->get('/json/states.json');
        $states = json_decode($statesJson);
        foreach ($states as $state) {
            State::create([
                'id' => $state->id,
                'name' => $state->name,
                'country_id' => $state->country_id,
            ]);
        }
    }
}
