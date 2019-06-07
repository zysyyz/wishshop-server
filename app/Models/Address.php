<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(schema="Address", type="object")
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
 *   property="position",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="full_name",
 *   type="string",
 * )
 * @OA\Property(
 *   property="first_name",
 *   type="string",
 * )
 * @OA\Property(
 *   property="last_name",
 *   type="string",
 * )
 * @OA\Property(
 *   property="email",
 *   type="string",
 * )
 * @OA\Property(
 *   property="phone_number",
 *   type="string",
 * )
 * @OA\Property(
 *   property="country",
 *   type="string",
 * )
 * @OA\Property(
 *   property="province",
 *   type="string",
 * )
 * @OA\Property(
 *   property="city",
 *   type="string",
 * )
 * @OA\Property(
 *   property="region",
 *   type="string",
 * )
 * @OA\Property(
 *   property="line1",
 *   type="string",
 * )
 * @OA\Property(
 *   property="line2",
 *   type="string",
 * )
 * @OA\Property(
 *   property="postal_code",
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
class Address extends Model
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
        'position',
        'full_name',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'country',
        'province',
        'city',
        'region',
        'line1',
        'line2',
        'postal_code',
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
