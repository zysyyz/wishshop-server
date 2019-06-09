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
     *   @OA\Parameter(
     *     description="Category Id",
     *     in="query",
     *     name="category_id",
     *     @OA\Schema(type="integer")
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
        $query = Product::with(!$include ? [] : $include)
            ->orderBy('created_at', 'desc')
            ->where('store_id', $store_id);

        $category_id = $request->input('category_id');
        if ($category_id) {
            // 当前分类及包含下一层级分类添加到查询条件中
            $query->whereIn('category_id', function($subquery) use ($category_id){
                $subquery->select('id')->from('categories');
                $subquery->where('id', $category_id);
                $subquery->orWhere('parent_id', $category_id);
            });
        }

        $q =  $request->input('q');
        if ($q) {
            $query->where(function ($subquery) use ($q) {
                $subquery->orWhere('name', 'like', '%'.$q.'%');
                $subquery->orWhere('summary', 'like', '%'.$q.'%');
            });
        }

        $per_page = $request->input('per_page');
        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/products/{product_id}",
     *   summary="Get a specific product",
     *   tags={"products"},
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
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     *   security={{
     *     "jwt_auth":{}
     *   }},
     * )
     */
    public function show(Request $request, $store_id, $product_id)
    {
        if (!is_numeric($store_id)) {
            $store = Store::where('slug', $store_id)->first();
            $store_id = $store->id;
        }

        $include = $request->input('include');
        $data = Product::with(!$include ? [] : $include)
            ->where('store_id', $store_id)
            ->where(function ($query) use ($product_id) {
                $query->where('id', $product_id);
                $query->orWhere('slug', $product_id);
            })
            ->first();

        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        return jsonSuccess(200, $data);
    }
}
