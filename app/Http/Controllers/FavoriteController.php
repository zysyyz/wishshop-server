<?php

namespace App\Http\Controllers;

use App\Models\Favorite;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class FavoriteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth');
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/favorites",
     *   summary="Get all Favorites",
     *   tags={"favorites"},
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
     *   @OA\Parameter(
     *     description="Include",
     *     in="query",
     *     name="include",
     *     @OA\Schema(
     *       type="array",
     *       @OA\Items(type="string"),
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

        $per_page = $request->input('per_page');

        $include = $request->input('include');
        $query = Favorite::with(!$include ? [] : $include)
            ->where('store_id', $store_id)
            ->orderBy('created_at', 'desc');

        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Post(
     *   path="/stores/{store_id}/favorites",
     *   summary="Create a favorite",
     *   tags={"favorites"},
     *   @OA\Parameter(
     *     description="Store Id (or slug)",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(
     *           property="target_type",
     *           type="string",
     *           description="Target type",
     *         ),
     *         @OA\Property(
     *           property="target_id",
     *           type="string",
     *           description="Target Id",
     *         ),
     *       ),
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
    public function store(Request $request, $store_id)
    {
        if (!is_numeric($store_id)) {
            $store = Store::where('slug', $store_id)->first();
            $store_id = $store->id;
        }
        $params = $request->all();
        $params = array_merge($params, [
            'store_id' => $store_id,
            'user_id' => Auth::id(),
        ]);

        $data = Favorite::withTrashed()->updateOrCreate(
            [
                'store_id' => $store_id,
                'user_id' => Auth::id(),
                'target_type' => $params['target_type'],
                'target_id' => $params['target_id']
            ],
            $params
        );

        if ($data) {
            return jsonSuccess(201, $data);
        }
        return jsonFailure();
    }

    /**
     * @OA\Delete(
     *   path="/stores/{store_id}/favorites/{favorite_id}",
     *   summary="Delete a favorite",
     *   tags={"favorites"},
     *   @OA\Parameter(
     *     description="Store Id (or slug)",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     description="Favorite Id",
     *     in="path",
     *     name="favorite_id",
     *     required=true,
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
    public function destroy(Request $request, $store_id, $favorite_id)
    {
        if (!is_numeric($store_id)) {
            $store = Store::where('slug', $store_id)->first();
            $store_id = $store->id;
        }

        $result = Favorite::where('id', $favorite_id)
            ->where('store_id', $store_id)
            ->where('user_id', Auth::id())
            ->delete();

        if ($result) {
            return jsonSuccess(200);
        }
        return jsonFailure(404, 'Not found');
    }
}
