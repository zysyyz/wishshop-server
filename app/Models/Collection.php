<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(schema="Collection", type="object")
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
 *   property="slug",
 *   type="string",
 * )
 * @OA\Property(
 *   property="position",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="name",
 *   type="string",
 * )
 * @OA\Property(
 *   property="image_url",
 *   type="string",
 * )
 * @OA\Property(
 *   property="description",
 *   type="string",
 * )
 * @OA\Property(
 *   property="view_by",
 *   type="string",
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
class Collection extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'slug',
        'position',
        'name',
        'image_url',
        'description',
        'view_by',
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

    public function items()
    {
        return $this->hasMany('App\Models\CollectionItem')
            ->orderBy('position', 'asc')
            ->orderBy('created_at', 'desc');
    }
}
