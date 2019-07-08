<?php

namespace App\Http\Controllers;

use App\Models\User;

use Auth;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Requests;

class AccountController extends Controller
{

    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwtAuth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;

        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'register',
                'login',
            ]
        ]);
    }

    /**
     * @OA\Post(
     *   path="/accounts/register",
     *   tags={"account"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(
     *           property="name",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="email",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="password",
     *           type="string",
     *         )
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *   ),
     * )
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|min:2|max:32',
            'email'    => 'required|email|unique:users',
            'password' => 'required|between:6,32',
        ]);

        $params = $request->only(
            'name',
            'email',
            'password',
            'use_gravatar'
        );
        $params['password'] = app('hash')->make($params['password']);

        if (!isset($params['use_gravatar'])) {
            $params = array_merge($params, [
                'use_gravatar' => true
            ]);
        }

        $user = new User($params);
        $user->useGravatar($params['use_gravatar'], $params);

        if ($user->save()) {
            return $this->login($request);
        }
        return jsonFailure(500);
    }

    /**
     * @OA\Post(
     *   path="/accounts/login",
     *   tags={"account"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(
     *           property="email",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="password",
     *           type="string",
     *         )
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *   ),
     * )
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|exists:users',
            'password' => 'required|between:6,32',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = $this->jwtAuth->attempt($credentials)) {
                return jsonFailure(401, trans('auth.failed'));
            }
            $user = User::find(Auth::id());
            // 设置JWT令牌
            $user->jwt_token = [
                'access_token' => $token,
                'expires_in'   => Carbon::now()->addMinutes(config('jwt.ttl'))->timestamp
            ];
            return jsonSuccess(200, $user);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return jsonFailure(500, trans('jwt.could_not_create_token'));
        }
    }

    /**
     * @OA\Post(
     *   path="/accounts/logout",
     *   tags={"account"},
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *   ),
     *   security={{
     *     "jwt_auth":{}
     *   }},
     * )
     */
    public function logout(Request $request)
    {
        try {
            $this->jwtAuth->parseToken()->invalidate();
        } catch (TokenBlacklistedException $e) {
            return jsonFailure(500, trans('jwt.the_token_has_been_blacklisted'));
        } catch (JWTException $e) {
            // 忽略该异常（Authorization为空时会发生）
        }
        return jsonSuccess();
    }
}
