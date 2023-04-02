<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="BusLineResource",
 *     description="Bus Line resource",
 *     @OA\Xml(
 *         name="BusLineResource"
 *     )
 * )
 */
class BusLineResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\BusLine[]
     */
    private $data;
}
