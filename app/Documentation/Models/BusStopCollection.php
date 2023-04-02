<?php

namespace App\Documentation\Models;

/**
 * @OA\Schema(
 *     schema="BusStopCollection",
 *     type="object",
 *         @OA\Property(
 *             property="type",
 *             type="string",
 *             example="FeatureCollection"
 *         ),
 *         @OA\Property(
 *             property="features",
 *             type="array",
 *             @OA\Items(
 *                  oneOf={
 *                      @OA\Schema(ref="#/components/schemas/BusStopFeatureWithoutLineId"),
 *                  }
 *              ),
 *          ),
 *             example={
 *                 {
 *                     "type": "Feature",
 *                     "properties": {
 *                         "name": "Tržni centar (A)",
 *                         "id": 336,
 *                         "type": "bus-stop",
 *                     },
 *                     "geometry": {
 *                         "type": "Point",
 *                         "coordinates": {
 *                             42.43146669,
 *                             19.27915313
 *                         }
 *                     }
 *                 },
 *                 {
 *                     "type": "Feature",
 *                     "properties": {
 *                         "name": "Donja Gorica (A)",
 *                         "id": 337,
 *                         "type": "bus-stop",
 *                     },
 *                     "geometry": {
 *                         "type": "Point",
 *                         "coordinates": {
 *                             42.43133438,
 *                             19.28015506
 *                         }
 *                     }
 *                 },
 *                 {
 *                     "type": "Feature",
 *                     "properties": {
 *                         "name": "Donja Gorica (A)",
 *                         "id": 337,
 *                         "type": "bus-stop",
 *                     },
 *                     "geometry": {
 *                         "type": "Point",
 *                         "coordinates": {
 *                             42.43133438,
 *                             19.28015506
 *                         }
 *                     }
 *                 },
 *             }
 *     )
 * )
 */
class BusStopCollection
{
}
