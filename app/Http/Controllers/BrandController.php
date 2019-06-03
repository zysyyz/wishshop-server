<?php

namespace App\Http\Controllers;

use App\Models\Brand;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class BrandController extends Controller
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
     *   path="/stores/{store_id}/brands",
     *   summary="Get all Brands",
     *   tags={"brands"},
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
    public function index(Request $request, $store_id)
    {
        $per_page = $request->input('per_page');

        $query = Brand::orderBy('created_at', 'desc')
            ->where('store_id', $store_id);

        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/brands/{brand_id}",
     *   summary="Get a specific brand",
     *   tags={"brands"},
     *   @OA\Parameter(
     *     description="Store Id (or slug)",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     description="Brand Id (or slug)",
     *     in="path",
     *     name="brand_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     * )
     */
    public function show(Request $request, $store_id, $brand_id)
    {
        $include = $request->input('include');
        $data = Brand::with(!$include ? [] : $include)
            ->where('store_id', $store_id)
            ->where(function ($query) use ($brand_id) {
                $query->where('id', $brand_id);
                $query->orWhere('slug', $brand_id);
            })
            ->first();

        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        return jsonSuccess(200, $data);
    }
}
