<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(schema="Order", type="object")
 * @OA\Property(
 *   property="id",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="store_id",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="user_id",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="number",
 *   type="string",
 * )
 * @OA\Property(
 *   property="reference_number",
 *   type="string",
 * )
 * @OA\Property(
 *   property="subtotal",
 *   type="number",
 * )
 * @OA\Property(
 *   property="total",
 *   type="number",
 * )
 * @OA\Property(
 *   property="status",
 *   type="string",
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
class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'user_id',
        'number',
        'reference_number',
        'subtotal',
        'total',
        'status',
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
