<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth', [
            'except' => [
                'show',
            ]
        ]);
        $this->middleware('jwt.check', [
            'only' => [
                'show',
            ]
        ]);
    }

    /**
     * @OA\Get(
     *   path="/admin/users/{user_id}",
     *   summary="Get a specific user",
     *   tags={"admin/users"},
     *   @OA\Parameter(
     *     description="User Id",
     *     in="path",
     *     name="user_id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     * )
     */
    public function show(Request $request, $user_id)
    {
        $include = Auth::id() == $user_id ? ['settings'] : [];

        $data = User::with($include)->where('id', $user_id)->first();
        if ($data) {
            return jsonSuccess(200, $data);
        }
        return jsonFailure(404, 'Not found');
    }
}
