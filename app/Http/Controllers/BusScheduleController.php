<?php

namespace App\Http\Controllers;

use App\Models\BusLine;
use App\Models\BusSchedule;
use Illuminate\Http\Request;

class BusScheduleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/bus-lines/{busLine}/schedule",
     *     operationId="getBusLineSchedule",
     *     summary="Get bus line schedule",
     *     description="Returns a single bus line schedule object identified by its ID",
     *     tags={"Bus Lines"},
     *     @OA\Parameter(
     *         name="busLine",
     *         in="path",
     *         description="ID of the bus line to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *                 ref="#/components/schemas/BusSchedule"
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Bus line not found"
     *     )
     * )
     */
    public function index(Request $request, BusLine $busLine)
    {
        return response()->json($busLine->schedule);
    }
}
