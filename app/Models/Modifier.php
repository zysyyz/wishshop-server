<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(schema="Modifier", type="object")
 * @OA\Property(
 *   property="id",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="user_id",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="product_id",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="title",
 *   type="string",
 * )
 * @OA\Property(
 *   property="choose_type",
 *   type="string",
 * )
 * @OA\Property(
 *   property="choose_at_least",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="choose_up_to",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="deleted_at",
 *   type="string",
 *   format="date-time",
 * )
 * @OA\Property(
 *   property="created_at",
 *   type="string",
 *   format="date-time",
 * )
 * @OA\Property(
 *   property="updated_at",
 *   type="string",
 *   format="date-time",
 * )
 */
class Modifier extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'choose_type',
        'choose_at_least',
        'choose_up_to',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];
}
