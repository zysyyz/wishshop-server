<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Store;

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
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/orders",
     *   summary="Get all Orders",
     *   tags={"orders"},
     *   @OA\Parameter(
     *     description="Store Id (or slug)",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
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
    public function index(Request $request, $store_id)
    {
        if (!is_numeric($store_id)) {
            $store = Store::where('slug', $store_id)->first();
            $store_id = $store->id;
        }

        $include = $request->input('include');
        $query = Order::with(!$include ? [] : $include)
            ->where('store_id', $store_id)
            // ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        $per_page = $request->input('per_page');
        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/orders/{number}",
     *   summary="Get a specific order",
     *   tags={"orders"},
     *   @OA\Parameter(
     *     description="Store Id (or slug)",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     description="Order number",
     *     in="path",
     *     name="number",
     *     required=true,
     *     @OA\Schema(type="string")
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
    public function show(Request $request, $store_id, $number)
    {
        if (!is_numeric($store_id)) {
            $store = Store::where('slug', $store_id)->first();
            $store_id = $store->id;
        }

        $include = $request->input('include');
        $data = Order::with(!$include ? [] : $include)
            ->where('store_id', $order_id)
            ->where('user_id', Auth::id())
            ->where('number', $number)
            ->first();

        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        return jsonSuccess(200, $data);
    }
}
