<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Bus",
 *     title="Bus",
 *     description="Bus model",
 *     @OA\Property(
 *         property="id",
 *         description="The unique identifier of the bus.",
 *         type="integer",
 *         format="int64",
 *         readOnly=true,
 *     ),
 *     @OA\Property(
 *         property="key",
 *         description="The key of the bus.",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="bus_line_id",
 *         description="The ID of the bus line that this bus belongs to.",
 *         type="integer",
 *         format="int64",
 *     )
 * )
 */
class Bus extends Model
{
    protected $fillable = [
        'key',
        'bus_line_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function busLine()
    {
        return $this->belongsTo(BusLine::class);
    }
}
