<?php

namespace App\Http\Controllers;

use App\Events\BusLocationUpdateEvent;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/buses",
     *     summary="Get a list of all buses",
     *     tags={"Bus"},
     *      security={{"sanctum": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Bus")
     *         )
     *     ),
     * )
     */
    public function index(Request $request)
    {
        $buses = Bus::all();

        return response()->json($buses);
    }

    /**
     * @OA\Post(
     *     path="/buses",
     *     summary="Create a new bus",
     *     tags={"Bus"},
     *      security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         description="Bus object that needs to be added",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BusCreate")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Bus created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Bus")
     *     ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthenticatedError")
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *      )
     * )
     */
    public function store(Request $request, Bus $bus)
    {
        $this->validate($request, [
            'bus_line_id' => 'required|exists:bus_lines,id',
        ]);

        $bus = Bus::create([
            'key' => Str::random(32),
            'bus_line_id' => $request->bus_line_id,
        ]);

        return response()->json($bus, 201);
    }

    /**
     * @OA\Delete(
     *     path="/buses/{bus}",
     *     summary="Delete a bus",
     *     tags={"Bus"},
     *      security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="bus",
     *         in="path",
     *         description="ID of the bus that needs to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthenticatedError")
     *      ),
     *     @OA\Response(
     *         response="404",
     *         description="Bus not found"
     *     ),
     * )
     */
    public function destroy(Bus $bus)
    {
        $bus->delete();

        return response()->json(null, 204);
    }

    /**
     * @OA\Post(
     *     path="/bus/update-location",
     *     summary="Updates the current location of a bus",
     *     description="Updates the current location of a bus",
     *     operationId="updateBusLocation",
     *     tags={"Bus"},
     *     @OA\RequestBody(
     *         description="The key, longitude and latitude of the update",
     *         required=true,
     *         @OA\JsonContent(
     *              required={"key", "longitude", "latitude"},
     *              @OA\Property(property="key", type="string", example=123),
     *              @OA\Property(property="longitude", type="number", format="float", example=-122.4194),
     *              @OA\Property(property="latitude", type="number", format="float", example=37.7749)
     *         ),
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Bus line location updated successfully, busLocationUpdateEvent dispatched",
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *      )
     * )
     */
    public function updateLocation(Request $request)
    {
        $this->validate($request, [
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'key' => 'required|exists:buses,key',
        ]);

        $bus = Bus::where('key', $request->get('key'))->first();

        // broadcast the busLocationUpdateEvent
        event(new BusLocationUpdateEvent($bus->bus_line_id, $bus->id, $request->get('longitude'), $request->get('latitude')));

        return response()->json(null, 204);
    }
}
