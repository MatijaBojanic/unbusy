<?php

namespace App\Documentation\Models\Features\Properties;

/**
 * @OA\Schema(
 *     schema="BusStopProperties",
 *     type="object",
 *     @OA\Property(property="name", type="string", example="Tržni centar (A)"),
 *     @OA\Property(property="id", type="integer", example=336),
 *     @OA\Property(property="type", type="string", example="bus-stop"),
 *     @OA\Property(property="line_id", type="integer", example=29)
 * )
*/
class BusStopProperties
{

}
