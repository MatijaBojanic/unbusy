<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BusSchedule extends Model
{
    public const DAY_TYPE_WEEKDAY = 'weekday';
    public const DAY_TYPE_SATURDAY_AND_HOLIDAYS = 'saturday_and_holidays';
    public const DAY_TYPE_SUNDAY = 'sunday';

    public const DAY_TYPES = [
        self::DAY_TYPE_WEEKDAY,
        self::DAY_TYPE_SATURDAY_AND_HOLIDAYS,
        self::DAY_TYPE_SUNDAY,
    ];

    protected $fillable = [
        'departure_time',
        'bus_line_id',
        'direction_name',
        'day_type',
    ];

    protected $visible = [
        'departure_time',
        'direction_name',
        'day_type',
    ];

    public function line()
    {
        return $this->belongsTo(BusLine::class);
    }

    public static function populateBusLineSchedule(BusLine $busLine, String $directionName, String $dayType, String $firstDepartureTime , int $intervalInMinutes, String $lastDepartureTime)
    {
        $departureTime = Carbon::parse($firstDepartureTime);
        $lastDepartureTime = Carbon::parse($lastDepartureTime);

        while ($departureTime->lte($lastDepartureTime)) {
            BusSchedule::create([
                'bus_line_id' => $busLine->id,
                'day_type' => $dayType,
                'departure_time' => $departureTime->toTimeString(),
                'direction_name' => $directionName,
            ]);

            $departureTime->addMinutes($intervalInMinutes);
        }
    }
}
