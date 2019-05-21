<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class ProductController extends Controller
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
     *   path="/stores/{store_id}/products",
     *   summary="Get all Products",
     *   tags={"products"},
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

        $query = Product::orderBy('created_at', 'desc');
        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/products/{product_id}",
     *   summary="Get a specific product",
     *   tags={"products"},
     *   @OA\Parameter(
     *     description="Store Id",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     description="Product Id",
     *     in="path",
     *     name="product_id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     * )
     */
    public function show(Request $request, $product_id)
    {
        $include = $request->input('include');
        $data = Product::with(!$include ? [] : $include)
            ->where('id', $product_id)
            ->orWhere('slug', $product_id)
            ->first();

        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        return jsonSuccess(200, $data);
    }
}
