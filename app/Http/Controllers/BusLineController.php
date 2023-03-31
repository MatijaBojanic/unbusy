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
    public function show(Request $request, BusLine $busLine)
    {
        return response()->json($busLine->toGeoJsonArray());
    }

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

        $pathwayCoordinates = collect($request->get('features'))
            ->firstWhere(fn($feature) => $feature['properties']['type'] === 'bus-line')['geometry']['coordinates'];

        $pathwayPoints = collect();

        foreach ($pathwayCoordinates as $pathwayCoordinate) {
            $pathwayPoints->push(new Point($pathwayCoordinate[0], $pathwayCoordinate[1]));
        }

        $busLine = BusLine::create([
            'name' => $request->get('features')[0]['properties']['name'],
            'pathway' => new LineString($pathwayPoints)
        ]);

        $busStops = collect($request->get('features'))
            ->filter(fn($feature) => $feature['properties']['type'] === 'bus-stop')
            ->map(fn($feature) => [
                'name' => $feature['properties']['name'],
                'location' => new Point($feature['geometry']['coordinates'][0], $feature['geometry']['coordinates'][1]),
            ])
            ->toArray();

        $toBeAttachedBusStops = [];
        $busStopOrder = 1;

        foreach ($busStops as $busStop) {
            $newBusStop = BusStop::create($busStop);
            $toBeAttachedBusStops[$newBusStop->id] = ['order' => $busStopOrder];

            $busStopOrder++;
        }

        $busLine->stops()->attach($toBeAttachedBusStops);

        return response()->json($busLine->toGeoJsonArray());
    }
}
