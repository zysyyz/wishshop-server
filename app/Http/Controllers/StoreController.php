<?php

namespace App\Http\Controllers;

use App\Models\Store;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class StoreController extends Controller
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
                'index',
                'show',
            ]
        ]);
        $this->middleware('jwt.check', [
            'only' => [
                'index',
                'show',
            ]
        ]);
    }

    /**
     * @OA\Get(
     *   path="/stores",
     *   summary="Get all Stores",
     *   tags={"stores"},
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
     * )
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page');

        $query = Store::orderBy('created_at', 'desc');
        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}",
     *   summary="Get a specific store",
     *   tags={"stores"},
     *   @OA\Parameter(
     *     description="Store Id",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     * )
     */
    public function show(Request $request, $store_id)
    {
        $include = $request->input('include');
        $data = Store::with(!$include ? [] : $include)
            ->where(function ($query) use ($store_id) {
                $query->where('id', $store_id);
                $query->orWhere('slug', $store_id);
            })
            ->first();

        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        return jsonSuccess(200, $data);
    }
}
