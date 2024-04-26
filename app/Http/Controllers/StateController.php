<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class StateController extends Controller
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
