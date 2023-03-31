<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\LineString;
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

    public function toGeoJsonArray($withLineId = false)
    {
        $busLineGeoJson =  [
            'type' => 'Feature',
            'properties' => [
                'name' => $this->name,
                'id' => $this->id,
            ],
            'geometry' => [
                'type' => 'LineString',
                'coordinates' => $this->pathway->getCoordinates(),
            ],
        ];

        $geoJson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        $geoJson['features'][] = $busLineGeoJson;

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
}
