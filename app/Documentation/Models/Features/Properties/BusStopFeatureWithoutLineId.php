<?php

namespace App\Documentation\Models\Features\Properties;

/**
 * @OA\Schema(
 *     schema="BusStopFeatureWithoutLineId",
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
 *              @OA\Schema(ref="#/components/schemas/BusStopPropertiesWithoutLineId")
 *          }
 *      ),
 *      @OA\Property(
 *          property="geometry",
 *          type="object",
 *          @OA\Property(
 *                  property="type",
 *                  type="string",
 *                  example="Point"
 *          ),
 *          @OA\Property(
 *              property="coordinates",
 *              type="array",
 *              @OA\Items(
 *                  type="number",
 *                  example=19.27913681
 *              ),
 *              @OA\Items(
 *                  type="number",
 *                  example=42.43142816
 *              ),
 *              example={19.27913681, 42.43142816},
 *          )
 *      )
 *  )
 */
class BusStopFeatureWithoutLineId
{

}
