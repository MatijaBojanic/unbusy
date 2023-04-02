<?php

namespace App\Http\Controllers;

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
     * @OA\Post(
     *      path="/bus-lines",
     *      operationId="storeBusLine",
     *      tags={"Bus Lines"},
     *      summary="Store new bus line",
     *      description="Returns the newly created bus line",
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
     * Detach all the stops from the Bus Line and delete it
     *
     * @param Request $request
     * @param BusLine $busLine
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, BusLine $busLine)
    {
        $busLine->stops()->detach();
        $busLine->delete();

        return response()->json([
            'message' => 'Bus line deleted'
        ]);
    }
}
