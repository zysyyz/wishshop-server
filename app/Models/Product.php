<?php

namespace App\Models;

use Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(schema="Product", type="object")
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
 *   property="brand_id",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="brand_name",
 *   type="string",
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
class Product extends Model
{
    use SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'favorited_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'brand_name',
        'name',
        'image_url',
        'description',
        'sku',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function getFavoritedAtAttribute()
    {
        if (Auth::check()) {
            $favorite = Favorite::where([
                'user_id' => Auth::id(),
                'store_id' => $this->store_id,
                'target_type' => 'product',
                'target_id' => $this->id,
            ])->first();
            if ($favorite) {
                return $favorite->updated_at->format('Y-m-d H:i:s');;
            }
        }
        return null;
    }

    public function contents()
    {
        return $this->hasMany('App\Models\Content')
            ->orderBy('position', 'asc')
            ->orderBy('created_at', 'desc')
            ->select('id', 'store_id', 'product_id', 'position', 'type', 'content', 'meta');
    }
}
