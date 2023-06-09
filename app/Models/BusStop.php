<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Enums\Srid;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class BusStop extends Model
{
    use HasSpatial;
    protected $fillable = [
        'name',
        'location'
    ];

    protected $casts = [
        'location' => Point::class,
    ];

    public function lines()
    {
        return $this->belongsToMany(BusLine::class, 'bus_line_bus_stop', 'bus_stop_id', 'bus_line_id');
    }

    public function toGeoJsonArray($lineId = null)
    {
        $busStopGeoJson =  [
            'type' => 'Feature',
            'properties' => [
                'name' => $this->name,
                'id' => $this->id,
                'type' => 'bus-stop'
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => $this->location->getCoordinates(),
            ],
        ];

        if($lineId) {
            $busStopGeoJson['properties']['line_id'] = $lineId;
        }

        return $busStopGeoJson;
    }

    public function toGeoJsonArrayWithLines()
    {
        $geoJson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        $geoJson['features'][] = $this->toGeoJsonArray();

        foreach($this->lines as $busLine) {
            $geoJson['features'][] = $busLine->toGeoJsonArrayWithoutStops();
        }

        return $geoJson;
    }

    public function toGeoJson()
    {
        return json_encode($this->toGeoJsonArray());
    }

    public static function collectionToGeoJsonArray($busStops)
    {
        $geoJson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach($busStops as $busStop) {
            $geoJson['features'][] = $busStop->toGeoJsonArray();
        }

        return $geoJson;
    }
}
