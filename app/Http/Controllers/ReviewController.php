<?php

namespace App\Http\Controllers;

use App\Models\Review;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class ReviewController extends Controller
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
            ]
        ]);
        $this->middleware('jwt.check', [
            'only' => [
                'index',
            ]
        ]);
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/products/{product_id}/reviews",
     *   summary="Get all Reviews",
     *   tags={"reviews"},
     *   @OA\Parameter(
     *     description="Store Id (or slug)",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     description="Product Id (or slug)",
     *     in="path",
     *     name="product_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     description="Page",
     *     in="query",
     *     name="page",
     *     @OA\Schema(type="integer"),
     *   ),
     *   @OA\Parameter(
     *     description="Per page",
     *     in="query",
     *     name="per_page",
     *     @OA\Schema(type="integer"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     * )
     */
    public function index(Request $request, $store_id, $product_id)
    {
        $include = $request->input('include');
        $query = Review::with(!$include ? [] : $include)
            ->orderBy('created_at', 'desc')
            ->where('store_id', $store_id)
            ->where('product_id', $product_id);

        $per_page = $request->input('per_page');

        return jsonPagination(200, $query->paginate($per_page));
    }
}
