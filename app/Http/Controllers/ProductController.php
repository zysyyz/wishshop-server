<?php

namespace App\Http\Controllers;

use App\Models\Order;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class OrderController extends Controller
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
     *   path="/stores/{store_id}/orders",
     *   summary="Get all Orders",
     *   tags={"orders"},
     *   @OA\Parameter(
     *     description="Store Id",
     *     in="path",
     *     name="store_id",
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
     * )
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page');

        $query = Order::orderBy('created_at', 'desc');
        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/orders/{order_id}",
     *   summary="Get a specific order",
     *   tags={"orders"},
     *   @OA\Parameter(
     *     description="Store Id",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     description="Order Id",
     *     in="path",
     *     name="order_id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     * )
     */
    public function show(Request $request, $order_id)
    {
        $include = $request->input('include');
        $data = Order::with(!$include ? [] : $include)
            ->where('id', $order_id)
            ->orWhere('slug', $order_id)
            ->first();

        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        return jsonSuccess(200, $data);
    }
}
