<?php

namespace App\Documentation\Models;

/**
 * @OA\Schema(
 *     schema="BusStop",
 *     type="object",
 *     @OA\Property(property="name", type="string", example="Tržni centar (A)"),
 *     @OA\Property(property="id", type="integer", example=336),
 *     @OA\Property(property="type", type="string", example="bus-stop"),
 *     @OA\Property(property="line_id", type="integer", example=29),
 *     @OA\Property(property="geometry", type="object",
 *         @OA\Property(property="type", type="string", example="Point"),
 *         @OA\Property(property="coordinates", type="array", @OA\Items(type="number", example={42.43146669, 19.27915313}))
 *     )
 * )
 */
class BusStop
{

}
