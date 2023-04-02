<?php

namespace Database\Factories;

use App\Models\BusLine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;

class BusLineFactory extends Factory
{
    protected $model = BusLine::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'pathway' => new LineString(collect([
                new Point(0, 0),
                new Point(1, 1),
                new Point(2, 2),
            ])),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
