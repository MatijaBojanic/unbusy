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
     * Returns the Bus line and its bus stops in the GeoJSON format
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusLine  $busLine
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BusLine $busLine)
    {
        return response()->json($busLine->toGeoJsonArray());
    }

    /**
     * @OA\Get(
     *      path="/bus-lines",
     *      operationId="getBusLinesList",
     *      tags={"BusLine"},
     *      summary="Get collection of bus lines",
     *      description="Returns a collection of bus lines",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/BusLineResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index(Request $request)
    {
        $busLines = BusLine::all();

        return response()->json(BusLine::collectionToGeoJsonArray($busLines));
    }

    /**
     * Create a Bus Line and its stops from a GeoJson request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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

        return response()->json($busLine->toGeoJsonArray());
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
