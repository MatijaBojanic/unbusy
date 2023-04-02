<?php

namespace App\Documentation\Models;

/**
 * @OA\Schema(
 *     schema="BusLineCollection",
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
 *                      @OA\Schema(ref="#/components/schemas/BusLineFeature"),
 *                      @OA\Schema(ref="#/components/schemas/BusStopFeature"),
 *                  }
 *              ),
 *          ),
 *
 *             example={
 *                 {
 *                     "type": "Feature",
 *                     "properties": {
 *                         "name": "Stari aerodrom - Donja gorica",
 *                         "type": "bus-line",
 *                         "id": 29
 *                     },
 *                     "geometry": {
 *                         "type": "LineString",
 *                         "coordinates": {
 *                             {19.27913681, 42.43142816},
 *                             {19.27913681, 42.43142816},
 *                             {19.27913681, 42.43142816},
 *                             {19.27913681, 42.43142816}
 *                         }
 *                     }
 *                 },
 *                 {
 *                     "type": "Feature",
 *                     "properties": {
 *                         "name": "Tržni centar (A)",
 *                         "id": 336,
 *                         "type": "bus-stop",
 *                         "line_id": 29
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
 *                         "line_id": 29
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
 *                         "name": "Donja gorica - Rogami ",
 *                         "type": "bus-line",
 *                         "id": 30
 *                     },
 *                     "geometry": {
 *                         "type": "LineString",
 *                         "coordinates": {
 *                             {19.27913681, 42.43142816},
 *                             {19.27913681, 42.43142816},
 *                             {19.27913681, 42.43142816},
 *                             {19.27913681, 42.43142816}
 *                         }
 *                     }
 *                 },
 *                 {
 *                     "type": "Feature",
 *                     "properties": {
 *                         "name": "Donja Gorica (A)",
 *                         "id": 337,
 *                         "type": "bus-stop",
 *                         "line_id": 30
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
class BusLineCollection
{
}
