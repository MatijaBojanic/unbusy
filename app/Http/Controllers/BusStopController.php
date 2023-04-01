<?php

namespace App\Http\Controllers;

use App\Models\BusStop;
use Illuminate\Http\Request;

class BusStopController extends Controller
{
    public function index()
    {
        return response()->json(BusStop::collectionToGeoJsonArray(BusStop::all()));
    }

    public function show(Request $request, BusStop $busStop)
    {
        return response()->json($busStop->toGeoJsonArrayWithLines());
    }

    public function delete(Request $request, BusStop $busStop)
    {
        $busStop->lines()->detach();

        $busStop->delete();

        return response()->json([
            'message' => 'Bus stop deleted successfully'
        ]);
    }
}
