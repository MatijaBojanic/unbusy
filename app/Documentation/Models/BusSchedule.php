<?php

namespace App\Documentation\Models;

/**
 * @OA\Schema(
 *     schema="BusSchedule",
 *     title="Bus Schedule",
 *     description="Bus Schedule for a specific bus line",
 *     @OA\Xml(
 *         name="BusSchedule"
 *     ),
 *     type="array",
 *     @OA\Items(
 *         @OA\Property(
 *             property="departure_time",
 *             type="string",
 *             format="time",
 *             example="05:15:00"
 *         ),
 *         @OA\Property(
 *             property="direction_name",
 *             type="string",
 *             example="Stari Aerodrom"
 *         ),
 *         @OA\Property(
 *             property="day_type",
 *             type="string",
 *             enum={"weekday", "saturday_and_holiday", "sunday"},
 *             example="weekday"
 *         )
 *      ),
 *      example={
 *          {
 *              "departure_time": "05:15:00",
 *              "direction_name": "Stari Aerodrom",
 *              "day_type": "weekday"
 *          },
 *          {
 *              "departure_time": "06:35:00",
 *              "direction_name": "Stari Aerodrom",
 *              "day_type": "weekday"
 *          },
 *          {
 *              "departure_time": "07:15:00",
 *              "direction_name": "Stari Aerodrom",
 *              "day_type": "weekday"
 *          }
 *      },
 * )
 */
class BusSchedule
{

}
