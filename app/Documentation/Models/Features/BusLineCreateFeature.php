<?php

namespace App\Documentation\Models\Features;

/**
 * @OA\Schema(
 *     schema="BusLineCreateFeature",
 *     type="object",
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          example="Feature"
 *      ),
 *      @OA\Property(
 *          property="properties",
 *          type="object",
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/BusLineCreateProperties")
 *          }
 *      ),
 *      @OA\Property(
 *          property="geometry",
 *          type="object",
 *          @OA\Property(
 *                  property="type",
 *                  type="string",
 *                  example="LineString"
 *          ),
 *          @OA\Property(
 *              property="coordinates",
 *              type="array",
 *              @OA\Items(
 *                  type="array",
 *                  @OA\Items(
 *                      type="number",
 *                      example=19.27913681
 *                  ),
 *                  @OA\Items(
 *                      type="number",
 *                      example=42.43142816
 *                  )
 *              ),
 *              example={
 *                  {19.27913681, 42.43142816},
 *                  {19.33333333, 42.33333333}
 *              }
 *          )
 *      )
 *  )
 */
class BusLineCreateFeature
{

}
