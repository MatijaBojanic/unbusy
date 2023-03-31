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

    public function toGeoJsonArray()
    {
        return [
            'type' => 'Feature',
            'properties' => [
                'name' => $this->name,
                'id' => $this->id,
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => $this->location->getCoordinates(),
            ],
        ];
    }

    public function toGeoJson()
    {
        return json_encode($this->toGeoJsonArray());
    }
}
