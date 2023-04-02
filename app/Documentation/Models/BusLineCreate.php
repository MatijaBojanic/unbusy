<?php

namespace App\Documentation\Models;

/**
 * @OA\Schema(
 *     schema="BusLineCreate",
 *     type="object",
 *         @OA\Property(
 *             property="type",
 *             type="string",
 *             example="FeatureCollection",
 *         ),
 *         @OA\Property(
 *             property="features",
 *             type="array",
 *             @OA\Items(
 *                  oneOf={
 *                      @OA\Schema(ref="#/components/schemas/BusLineCreateFeature"),
 *                      @OA\Schema(ref="#/components/schemas/BusStopCreateFeature"),
 *                  }
 *              ),
 *          ),
 *             example={
 *                 {
 *                     "type": "Feature",
 *                     "properties": {
 *                         "name": "Stari aerodrom - Donja gorica",
 *                         "type": "bus-line",
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
 *                         "type": "bus-stop"
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
 *                         "type": "bus-stop"
 *                     },
 *                     "geometry": {
 *                         "type": "Point",
 *                         "coordinates": {
 *                             42.43133438,
 *                             19.28015506
 *                         }
 *                     }
 *                 }
 *             }
 *     )
 * )
 */
class BusLineCreate
{
}
