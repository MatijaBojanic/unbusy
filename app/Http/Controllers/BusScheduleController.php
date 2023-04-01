<?php

namespace App\Http\Controllers;

use App\Models\BusLine;
use App\Models\BusSchedule;
use Illuminate\Http\Request;

class BusScheduleController extends Controller
{
    public function index(Request $request, BusLine $busLine)
    {
        return response()->json($busLine->schedule);
    }
}
