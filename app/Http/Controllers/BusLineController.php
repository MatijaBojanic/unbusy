<?php

namespace App\Http\Controllers;

use App\Events\BusLocationUpdateEvent;
use App\Models\BusLine;
use App\Models\BusStop;
use Illuminate\Http\Request;
use MatanYadaev\EloquentSpatial\Enums\Srid;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;

class BusLineController extends Controller
{
    /**
     * @OA\Get(
     *      path="/bus-lines",
     *      operationId="getBusLinesList",
     *      tags={"Bus Lines"},
     *      summary="Get collection of bus lines",
     *      description="Returns a collection of bus lines",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/BusLineCollection")
     *       )
     *     )
     */
    public function index(Request $request)
    {
        $busLines = BusLine::all();

        return response()->json(BusLine::collectionToGeoJsonArray($busLines));
    }

    /**
     * @OA\Get(
     *     path="/bus-lines/{busLine}",
     *     operationId="getBusLineById",
     *     summary="Get bus line by ID",
     *     description="Returns a single bus line object identified by its ID",
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
     *                 ref="#/components/schemas/BusLine"
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Bus line not found"
     *     )
     * )
     */
    public function show(Request $request, BusLine $busLine)
    {
        return response()->json($busLine->toGeoJsonArray());
    }

    /**
     * @OA\Post(
     *      path="/bus-lines",
     *      operationId="storeBusLine",
     *      tags={"Bus Lines"},
     *      summary="Store new bus line",
     *      description="Returns the newly created bus line",
     *      security={{"sanctum": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/BusLineCreate")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/BusLine")
     *       ),
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|string|in:FeatureCollection',
            'features' => 'required|array',
            'features.*.type' => 'required|string|in:Feature',
            'features.*.properties' => 'required|array',
            'features.*.properties.name' => 'required|string',
            'features.*.properties.type' => 'required|string|in:bus-line,bus-stop',
            'features.*.geometry' => 'required|array',
            'features.*.geometry.type' => 'required|string|in:LineString,Point',
            'features.*.geometry.coordinates' => 'required|array',
        ]);

        $busLine = BusLine::fromGeoJson($request->get('features'));

        return response()->json($busLine->toGeoJsonArray(), 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/bus-lines/{busLine}",
     *     summary="Delete a bus line",
     *     description="Delete a specific bus line by its ID",
     *     operationId="deleteBusLine",
     *     tags={"Bus Lines"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="busLine",
     *         in="path",
     *         description="ID of the bus line to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Bus line deleted successfully",
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
        $busLine->stops()->detach();
        $busLine->delete();

        //respond with 204
        return response()->json(null, 204);
    }


    /**
     * @OA\Post(
     *     path="/api/bus-lines/{busLine}/update-location",
     *     summary="Updates the current location of a specific bus",
     *     description="Updates the current location of a specific bus",
     *     operationId="updateBusLocation",
     *     tags={"Bus Lines"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="busLine",
     *         in="path",
     *         description="ID of the bus line",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="The bus_id, longitude and latitude of the update",
     *         required=true,
     *         @OA\JsonContent(
     *              required={"bus_id", "longitude", "latitude"},
     *              @OA\Property(property="bus_id", type="integer", example=123),
     *              @OA\Property(property="longitude", type="number", format="float", example=-122.4194),
     *              @OA\Property(property="latitude", type="number", format="float", example=37.7749)
     *         ),
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Bus line location updated successfully, busLocationUpdateEvent dispatched",
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
    public function updateLocation(Request $request, BusLine $busLine)
    {
        $this->validate($request, [
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'bus_id' => 'required|integer',
        ]);
        // broadcast the busLocationUpdateEvent
        event(new BusLocationUpdateEvent($busLine->id, $request->get('bus_id'), $request->get('longitude'), $request->get('latitude')));

        return response()->json(null, 204);
    }
}
