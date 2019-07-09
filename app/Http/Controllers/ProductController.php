<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
            ->where('products.store_id', $store_id);

        $category_id = $request->input('category_id');
        if ($category_id) {
            $category_ids = Category::where('id', $category_id)->orWhere('parent_id', $category_id)->select('id')->get();
            // 当前分类及包含下一层级分类添加到查询条件中
            $query->whereIn('category_id', function($subquery) use ($category_ids){
                $subquery->select('id')->from('categories');
                $subquery->whereIn('id', $category_ids);
                $subquery->orWhereIn('parent_id', $category_ids);
            });
        }

        $q =  $request->input('q');
        if ($q) {
            $query->where(function ($subquery) use ($q) {
                $subquery->orWhere('products.name', 'like', '%'.$q.'%');
                $subquery->orWhere('products.summary', 'like', '%'.$q.'%');
            });
        }

        if (Auth::check()) {
            $query->leftJoin('favorites', function ($join) {
                $join->on('products.id', '=', 'favorites.target_id')
                    ->where('favorites.user_id', Auth::id())
                    ->where('favorites.target_type', 'product')
                    ->whereNull('favorites.deleted_at');
            });
            $query->select(
                'products.*',
                'favorites.id as favorite_id',
                'favorites.updated_at as favorited_at'
            );
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
        $query = Product::with(!$include ? [] : $include)
            ->where('products.store_id', $store_id)
            ->where(function ($query) use ($product_id) {
                $query->where('products.id', $product_id);
                $query->orWhere('products.slug', $product_id);
            });

        if (Auth::check()) {
            $query->leftJoin('favorites', function ($join) {
                $join->on('products.id', '=', 'favorites.target_id')
                    ->where('favorites.user_id', Auth::id())
                    ->where('favorites.target_type', 'product')
                    ->whereNull('favorites.deleted_at');
            });
            $query->select(
                'products.*',
                'favorites.id as favorite_id',
                'favorites.updated_at as favorited_at'
            );
        }

        $data = $query->first();
        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        return jsonSuccess(200, $data);
    }
}
