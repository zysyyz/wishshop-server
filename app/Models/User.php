<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(schema="User", type="object")
 * @OA\Property(
 *   property="id",
 *   type="integer",
 *   format="int64",
 * )
 * @OA\Property(
 *   property="email",
 *   type="string",
 * )
 * @OA\Property(
 *   property="username",
 *   type="string",
 * )
 * @OA\Property(
 *   property="password",
 *   type="string",
 *   format="password",
 * )
 * @OA\Property(
 *   property="name",
 *   type="string",
 * )
 * @OA\Property(
 *   property="use_gravatar",
 *   type="boolean",
 * )
 * @OA\Property(
 *   property="avatar_url",
 *   type="string",
 * )
 * @OA\Property(
 *   property="age",
 *   type="integer",
 * )
 * @OA\Property(
 *   property="gender",
 *   type="string",
 *   enum={"secrecy", "male", "female"},
 * )
 * @OA\Property(
 *   property="birthday",
 *   type="string",
 * )
 * @OA\Property(
 *   property="company",
 *   type="string",
 * )
 * @OA\Property(
 *   property="website",
 *   type="string",
 * )
 * @OA\Property(
 *   property="bio",
 *   type="string",
 * )
 * @OA\Property(
 *   property="status",
 *   type="integer",
 * )
 * @OA\Property(
 *   property="site_admin",
 *   type="boolean",
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
class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use SoftDeletes, Authenticatable, Authorizable;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'use_gravatar' => 'boolean',
        'site_admin'   => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'name',
        'avatar_url',
        'age',
        'gender',
        'birthday',
        'company',
        'website',
        'bio',
        'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'use_gravatar',
        'status',
        'site_admin',
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    /**
     * 使用Gravatar
     *
     * @param $use_gravatar
     * @param $params
     */
    public function useGravatar($use_gravatar, &$params = [])
    {
        $this->use_gravatar = $use_gravatar;
        if ($use_gravatar) {
            $this->avatar_url = "https://cn.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) );
        } elseif (array_key_exists('avatar_url', $params)) {
            $this->avatar_url = $params['avatar_url'];
        }
        unset($params['avatar_url']);
        unset($params['use_gravatar']);
    }
}
