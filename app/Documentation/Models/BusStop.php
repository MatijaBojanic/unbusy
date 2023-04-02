<?php

namespace App\Documentation\Models;

/**
 * @OA\Schema(
 *     schema="BusStop",
 *     type="object",
 *     title="Bus Line",
 *     description="Bus Stop and all of its lines in GeoJSON format",
 *     @OA\Xml(
 *         name="BusStop"
 *     ),
 *     @OA\Property(
 *          property="type",
 *          type="string",
 *          example="FeatureCollection",
 *     ),
 *     @OA\Property(
 *          property="features",
 *          type="array",
 *          @OA\Items(
 *              oneOf={
 *                  @OA\Schema(ref="#/components/schemas/BusStopFeatureWithoutLineId"),
 *                  @OA\Schema(ref="#/components/schemas/BusLineFeature"),
 *              }
 *          ),
 *      ),
 *      example={
 *          {
 *              "type": "Feature",
 *              "properties": {
 *                  "name": "Tržni centar (A)",
 *                  "id": 336,
 *                  "type": "bus-stop"
 *              },
 *              "geometry": {
 *                  "type": "Point",
 *                  "coordinates": {
 *                      42.43146669,
 *                      19.27915313
 *                  }
 *              }
 *          },
 *          {
 *              "type": "Feature",
 *              "properties": {
 *                  "name": "Stari aerodrom - Donja gorica",
 *                  "type": "bus-line",
 *                  "id": 29
 *              },
 *              "geometry": {
 *                  "type": "LineString",
 *                  "coordinates": {
 *                      {19.27913681, 42.43142816},
 *                      {19.27913681, 42.43142816},
 *                      {19.27913681, 42.43142816},
 *                      {19.27913681, 42.43142816}
 *                  }
 *              }
 *          },
 *          {
 *              "type": "Feature",
 *              "properties": {
 *                  "name": "Donja gorica - Rogami ",
 *                  "type": "bus-line",
 *                  "id": 30
 *              },
 *              "geometry": {
 *                  "type": "LineString",
 *                  "coordinates": {
 *                      {19.27913681, 42.43142816},
 *                      {19.27913681, 42.43142816},
 *                      {19.27913681, 42.43142816},
 *                      {19.27913681, 42.43142816}
 *                  }
 *              }
 *          },
 *      }
 * )
 */
class BusStop
{

}
