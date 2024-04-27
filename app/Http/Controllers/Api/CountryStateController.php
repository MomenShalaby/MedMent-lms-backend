<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CountryStateController extends Controller
{
    use HttpResponses;
    public function index(Country $country)
    {
        $country->states;
        return $this->success([
            'country' => $country,
        ]);
    }
}
