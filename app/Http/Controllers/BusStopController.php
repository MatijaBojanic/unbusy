<?php

namespace App\Http\Controllers;

use App\Models\BusStop;
use Illuminate\Http\Request;

class BusStopController extends Controller
{
    /**
     * @OA\Get(
     *      path="/bus-stops",
     *      operationId="getBusStopsList",
     *      tags={"Bus Stops"},
     *      summary="Get collection of bus stops",
     *      description="Returns a collection of bus stops",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/BusStopCollection")
     *       )
     *     )
     */
    public function index()
    {
        return response()->json(BusStop::collectionToGeoJsonArray(BusStop::all()));
    }

    /**
     * @OA\Get(
     *     path="/bus-stops/{busStop}",
     *     operationId="getBusStopById",
     *     summary="Get bus stop by ID",
     *     description="Returns a single bus stop object identified by its ID",
     *     tags={"Bus Stops"},
     *     @OA\Parameter(
     *         name="busStop",
     *         in="path",
     *         description="ID of the bus stop to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *                 ref="#/components/schemas/BusStop"
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Bus line not found"
     *     )
     * )
     */
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
