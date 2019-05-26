<?php

namespace App\Http\Controllers;

use App\Models\Collection;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class CollectionController extends Controller
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
     *   path="/stores/{store_id}/collections",
     *   summary="Get all Collections",
     *   tags={"collections"},
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
     * )
     */
    public function index(Request $request)
    {
        $query = Collection::orderBy('created_at', 'desc');

        $per_page = $request->input('per_page');
        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/collections/{collection_id}",
     *   summary="Get a specific collection",
     *   tags={"collections"},
     *   @OA\Parameter(
     *     description="Store Id",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     description="Collection Id (or slug)",
     *     in="path",
     *     name="collection_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *   ),
     * )
     */
    public function show(Request $request, $collection_id)
    {
        $include = $request->input('include');
        $data = Collection::with(!$include ? [] : $include)
            ->orWhere(function ($query) use ($collection_id) {
                $query->where('id', $collection_id);
                $query->orWhere('slug', $collection_id);
            })
            ->first();

        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        return jsonSuccess(200, $data);
    }
}
