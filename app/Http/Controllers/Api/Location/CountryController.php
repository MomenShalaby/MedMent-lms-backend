<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Traits\CanLoadRelationships;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use HttpResponses;
    use CanLoadRelationships;

    private $relations = ['states'];

    public function index()
    {
        return $this->success([
            "countries" => Country::all(),
        ]);
    }

    public function show(Request $request, Country $country)
    {


        // $country->load('states');

        return $this->success([
            "country" => $this->loadRelationships($country),
        ]);


    }


}
