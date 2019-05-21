<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class CategoryController extends Controller
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
     *   path="/stores/{store_id}/categories",
     *   summary="Get all Categories",
     *   tags={"categories"},
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
     *   @OA\Parameter(
     *     description="Parent Id",
     *     in="query",
     *     name="parent_id",
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
        $query = Category::orderBy('created_at', 'desc');

        $parent_id = $request->input('parent_id');

        if (isset($parent_id) && !empty($parent_id)) {
            $query->where('parent_id', $parent_id);
        }

        $per_page = $request->input('per_page');
        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/categories/{category_id}",
     *   summary="Get a specific category",
     *   tags={"categories"},
     *   @OA\Parameter(
     *     description="Store Id",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     description="Category Id",
     *     in="path",
     *     name="category_id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     * )
     */
    public function show(Request $request, $category_id)
    {
        $include = $request->input('include');
        $data = Category::with(!$include ? [] : $include)
            ->where('id', $category_id)
            ->orWhere('slug', $category_id)
            ->first();

        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        return jsonSuccess(200, $data);
    }
}
