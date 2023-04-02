<?php

namespace App\Documentation\Responses;

/**
 *  @OA\Schema(
 *      schema="ValidationError",
 *      type="object",
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="The type field is required. (and 1 more error)"
 *      ),
 *      @OA\Property(
 *          property="errors",
 *          type="object",
 *          @OA\AdditionalProperties(
 *              type="array",
 *              @OA\Items(type="string", example="The type field is required.")
 *          )
 *      )
 * )
 */
class ValidationError
{

}
