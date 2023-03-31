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

    public function toGeoJsonArray()
    {
        $busLineGeoJson =  [
            'type' => 'Feature',
            'properties' => [
                'name' => $this->name,
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

        foreach($this->busStops as $busStop) {
            $geoJson['features'][] = $busStop->toGeoJson();
        }

        return $geoJson;
    }

    public function toGeoJson()
    {
        return json_encode($this->toGeoJsonArray());
    }
}
