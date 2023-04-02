<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class BusLine extends Model
{
    use HasSpatial;

    protected $fillable = [
        'name',
        'pathway',
    ];

    protected $casts = [
        'pathway' => LineString::class,
    ];

    public function stops()
    {
        return $this->belongsToMany(BusStop::class, 'bus_line_bus_stop', 'bus_line_id', 'bus_stop_id');
    }

    public function schedule()
    {
        return $this->hasMany(BusSchedule::class);
    }

    public function toGeoJsonArrayWithoutStops()
    {
        return [
            'type' => 'Feature',
            'properties' => [
                'name' => $this->name,
                'type' => 'bus-line',
                'id' => $this->id,
            ],
            'geometry' => [
                'type' => 'LineString',
                'coordinates' => $this->pathway->getCoordinates(),
            ],
        ];
    }

    public function toGeoJsonArray($withLineId = false)
    {
        $geoJson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        $geoJson['features'][] = $this->toGeoJsonArrayWithoutStops();

        $busStops = $this->stops()
            ->orderBy('bus_line_bus_stop.order')
            ->get();

        foreach($busStops as $busStop) {
            $geoJson['features'][] = $busStop->toGeoJsonArray($this->id);
        }

        return $geoJson;
    }

    public function toGeoJson($withLineId = false)
    {
        return json_encode($this->toGeoJsonArray($withLineId));
    }

    public static function collectionToGeoJsonArray($busLines)
    {
        $multipleFeatureCollections = $busLines->map(fn($busLine) => $busLine->toGeoJsonArray(true));

        $geoJson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach($multipleFeatureCollections as $featureCollection) {
            $geoJson['features'] = array_merge($geoJson['features'], $featureCollection['features']);
        }

        return $geoJson;
    }

    public function saveToGeoJsonFile()
    {
        $geoJson = $this->toGeoJson();
        $fileName = $this->name . '.json';
        $filePath = storage_path('app/public/bus-lines/' . $fileName);
        file_put_contents($filePath, $geoJson);
    }

    public static function fromGeoJson($features)
    {
        $pathwayCoordinates = collect($features)
            ->firstWhere(fn($feature) => $feature['properties']['type'] === 'bus-line')['geometry']['coordinates'];

        $pathwayPoints = collect();

        foreach ($pathwayCoordinates as $pathwayCoordinate) {
            $pathwayPoints->push(new Point($pathwayCoordinate[0], $pathwayCoordinate[1]));
        }

        $busLine = BusLine::create([
            'name' => $features[0]['properties']['name'],
            'pathway' => new LineString($pathwayPoints)
        ]);

        $busStops = collect($features)
            ->filter(fn($feature) => $feature['properties']['type'] === 'bus-stop')
            ->map(fn($feature) => [
                'name' => $feature['properties']['name'],
                'location' => new Point($feature['geometry']['coordinates'][0], $feature['geometry']['coordinates'][1]),
            ])
            ->toArray();

        $toBeAttachedBusStops = [];
        $busStopOrder = 1;

        foreach ($busStops as $busStop) {
            $newBusStop = BusStop::whereName($busStop['name'])->first();

            if(!$newBusStop) {
                $newBusStop = BusStop::create($busStop);
            }

            $toBeAttachedBusStops[$newBusStop->id] = ['order' => $busStopOrder];

            $busStopOrder++;
        }

        $busLine->stops()->attach($toBeAttachedBusStops);

        return $busLine;
    }
}
