<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countriesJson = Storage::disk('local')->get('/json/countries.json');
        $countries = json_decode($countriesJson);
        foreach ($countries as $country) {
            Country::create([
                'id' => $country->id,
                'sortname' => $country->sortname,
                'name' => $country->name,
                'phoneCode' => $country->phoneCode,
            ]);
        }
        /*
        $json = Storage::disk('local')->get('/json/movies.json');
        $movies = json_decode($json, true);

        foreach ($movies as $movie) {
            Movie::query()->updateOrCreate([
                'title' => $movie['title'],
                'id_imdb' => $movie['id_imdb']
            ]);
        }
    }-

        */
    }
}
