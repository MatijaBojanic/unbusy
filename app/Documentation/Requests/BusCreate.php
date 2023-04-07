<?php

namespace App\Documentation\Requests;

/**
 * @OA\Schema(
 *     schema="BusCreate",
 *     type="object",
 *         @OA\Property(
 *             property="bus_line_id",
 *             type="integer",
 *             example="122",
 *         ),
 *             example={
 *                "bus_line_id": 122
 *        }
 *     )
 * )
 */
class BusCreate
{
}
