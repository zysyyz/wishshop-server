<?php

namespace App\Http\Controllers;

use App\Models\OrderLineItem;
use App\Models\Store;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class OrderLineItemController extends Controller
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
     *   path="/stores/{store_id}/orders/{number}/items",
     *   summary="Get all Items",
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
        $query = OrderLineItem::with(!$include ? [] : $include)
            ->where('store_id', $store_id)
            // ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        $per_page = $request->input('per_page');
        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Post(
     *   path="/stores/{store_id}/orders/{number}/items",
     *   summary="Create a item",
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
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(
     *           property="label",
     *           type="string",
     *           description="Label",
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
        return jsonFailure(500);
    }

    /**
     * @OA\Patch(
     *   path="/stores/{store_id}/orders/{number}/items/{item_id}",
     *   summary="Update a item",
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
     *   @OA\Parameter(
     *     description="Item Id",
     *     in="path",
     *     name="item_id",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         type="object",
     *         @OA\Property(
     *           property="label",
     *           type="string",
     *           description="Label",
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
    public function update(Request $request, $store_id, $address_id)
    {
        return jsonSuccess(500);
    }

    /**
     * @OA\Delete(
     *   path="/stores/{store_id}/orders/{number}/items/{item_id}",
     *   summary="Delete a item",
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
     *   @OA\Parameter(
     *     description="Item Id",
     *     in="path",
     *     name="item_id",
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

        return jsonFailure(500);
    }
}
