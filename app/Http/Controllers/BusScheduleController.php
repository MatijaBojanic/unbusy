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

    /**
     * @OA\Post(
     *     path="/bus-lines/{busLine}/schedules",
     *     summary="Create bus line schedule",
     *     description="Create a new schedule for a bus line",
     *     tags={"Bus Lines"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="busLine",
     *         in="path",
     *         description="ID of the bus line",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="first_departure_time",
     *                 type="string",
     *                 format="time",
     *                 description="The first departure time in format HH:mm:ss",
     *                 example="05:15:00"
     *             ),
     *             @OA\Property(
     *                 property="last_departure_time",
     *                 type="string",
     *                 format="time",
     *                 description="The last departure time in format HH:mm:ss",
     *                 example="22:15:00"
     *             ),
     *             @OA\Property(
     *                 property="interval_in_minutes",
     *                 type="integer",
     *                 description="The interval in minutes between departures",
     *                 example=60
     *             ),
     *             @OA\Property(
     *                 property="direction_name",
     *                 type="string",
     *                 description="The name of the direction for the schedule",
     *                 example="Stari Aerodrom"
     *             ),
     *             @OA\Property(
     *                 property="day_type",
     *                 type="string",
     *                 description="The day type for the schedule",
     *                 example="weekday",
     *                 enum={"weekday", "saturday_and_holiday", "sunday"}
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/BusSchedule")
     *     ),
     *     @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthenticatedError")
     *      ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * )
     */
    public function store(Request $request, BusLine $busLine)
    {
        $request->validate([
            'first_departure_time' => 'required|date_format:H:i:s',
            'last_departure_time' => 'required|date_format:H:i:s',
            'interval_in_minutes' => 'required|integer',
            'direction_name' => 'required|string',
            'day_type' => 'required|string|in:' . implode(',', BusSchedule::DAY_TYPES),
        ]);

        BusSchedule::populateBusLineSchedule(
            $busLine,
            $request->get('direction_name'),
            $request->get('day_type'),
            $request->get('first_departure_time'),
            $request->get('interval_in_minutes'),
            $request->get('last_departure_time')
        );

        return response()->json($busLine->schedule);
    }

    /**
     * @OA\Delete(
     *     path="/bus-lines/{busLine}/schedule",
     *     summary="Delete a bus line schedule",
     *     description="Delete a specific bus line's schedule",
     *     operationId="deleteBusLineSchedule",
     *     tags={"Bus Lines"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="busLine",
     *         in="path",
     *         description="ID of the bus line whose schedule to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Bus line schedule deleted successfully",
     *     ),
     *     @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthenticatedError")
     *      ),
     *     @OA\Response(
     *         response="404",
     *         description="Bus line not found"
     *     ),
     * )
     */
    public function destroy(Request $request, BusLine $busLine)
    {
        $busLine->schedule()->delete();

        return response()->json(null, 204);
    }
}
