<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSetting;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth');
    }

    /**
     * @OA\Get(
     *   path="/users/{user_id}/settings",
     *   summary="Get all settings",
     *   tags={"user_settings"},
     *   @OA\Parameter(
     *     description="User Id",
     *     in="path",
     *     name="user_id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     description="Page",
     *     in="query",
     *     name="page",
     *     @OA\Schema(
     *       type="integer",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     description="Per page",
     *     in="query",
     *     name="per_page",
     *     @OA\Schema(
     *       type="integer",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     *   security={{
     *     "jwt_auth":{}
     *   }},
     * )
     */
    public function index(Request $request, $user_id)
    {
        if ($user_id != Auth::id()) {
            return jsonFailure(403, '403 Forbidden');
        }

        $per_page = $request->input('per_page');

        $query = UserSetting::orderBy('created_at', 'desc');
        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Post(
     *   path="/users/{user_id}/settings",
     *   summary="Create a setting",
     *   tags={"user_settings"},
     *   @OA\Parameter(
     *     description="User Id",
     *     in="path",
     *     name="user_id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(
     *           property="type",
     *           type="string",
     *           description="Type",
     *           enum={"string", "number", "bool"},
     *         ),
     *         @OA\Property(
     *           property="key",
     *           type="string",
     *           description="Key",
     *         ),
     *         @OA\Property(
     *           property="value",
     *           type="string",
     *           description="Value",
     *         ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     *   security={{
     *     "jwt_auth":{}
     *   }},
     * )
     */
    public function store(Request $request, $user_id)
    {
        if ($user_id != Auth::id()) {
            return jsonFailure(403, '403 Forbidden');
        }

        $params = $request->all();
        $params = array_merge($params, [
            'user_id' => Auth::id()
        ]);

        $data = UserSetting::withTrashed()->updateOrCreate(
            [
                'user_id' => Auth::id(),
                'key' => $params['key'],
            ],
            $params
        );
        if ($data) {
            return jsonSuccess(201, $data);
        }
        return jsonFailure();
    }
}
