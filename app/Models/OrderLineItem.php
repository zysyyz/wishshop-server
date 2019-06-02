<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(schema="OrderLineItem", type="object")
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
 *
 * @OA\Property(
 *   property="purchase_type",
 *   type="string",
 * )
 * @OA\Property(
 *   property="purchase_id",
 *   type="string",
 * )
 * @OA\Property(
 *   property="label",
 *   type="string",
 * )
 * @OA\Property(
 *   property="price",
 *   type="number",
 * )
 * @OA\Property(
 *   property="original_price",
 *   type="number",
 * )
 * @OA\Property(
 *   property="quantity",
 *   type="number",
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
class OrderLineItem extends Model
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
        'purchase_type',
        'purchase_id',
        'label',
        'price',
        'original_price',
        'quantity',
        'subtotal',
        'total',
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
