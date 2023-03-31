<?php

namespace App\Http\Controllers;

use App\Models\BusLine;

class BusLineController extends Controller
{
    public function show(BusLine $busLine)
    {
        return response()->json($busLine->toGeoJsonArray());
    }
}
