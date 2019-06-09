<?php

namespace App\Http\Controllers;

use App\Models\Address;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class AddressController extends Controller
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
     *   path="/stores/{store_id}/addresses",
     *   summary="Get all Addresses",
     *   tags={"addresses"},
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

        $query = Address::whereRaw('1=1')
            ->where('store_id', $store_id)
            ->orderBy('position', 'asc')
            ->orderBy('created_at', 'desc');

        return jsonPagination(200, $query->paginate($per_page));
    }

    /**
     * @OA\Post(
     *   path="/stores/{store_id}/addresses",
     *   summary="Create a address",
     *   tags={"addresses"},
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
     *           property="full_name",
     *           type="string",
     *           description="Full name",
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

        $data = new Address($params);
        if ($data->save()) {
            return jsonSuccess(201, $data);
        }
        return jsonFailure();
    }

    /**
     * @OA\Get(
     *   path="/stores/{store_id}/addresses/{address_id}",
     *   summary="Get a specific address",
     *   tags={"addresses"},
     *   @OA\Parameter(
     *     description="Store Id (or slug)",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     description="Address Id (or slug)",
     *     in="path",
     *     name="address_id",
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
    public function show(Request $request, $store_id, $address_id)
    {
        $include = $request->input('include');
        $data = Address::with(!$include ? [] : $include)
            ->where('store_id', $store_id)
            ->where('user_id', Auth::id())
            ->where('id', $address_id)
            ->first();

        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        return jsonSuccess(200, $data);
    }

    /**
     * @OA\Patch(
     *   path="/stores/{store_id}/addresses/{address_id}",
     *   summary="Update a address",
     *   tags={"addresses"},
     *   @OA\Parameter(
     *     description="Store Id (or slug)",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     description="Address Id",
     *     in="path",
     *     name="address_id",
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
     *           property="full_name",
     *           type="string",
     *           description="Full name",
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
        $params = $request->all();
        $data = Address::where('id', $address_id)
            ->where('store_id', $store_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$data) {
            return jsonFailure(404, 'Not found');
        }

        $data->update($params);
        return jsonSuccess(200, $data);
    }

    /**
     * @OA\Delete(
     *   path="/stores/{store_id}/addresses/{address_id}",
     *   summary="Delete a address",
     *   tags={"addresses"},
     *   @OA\Parameter(
     *     description="Store Id (or slug)",
     *     in="path",
     *     name="store_id",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     description="Address Id",
     *     in="path",
     *     name="address_id",
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
    public function destroy(Request $request, $store_id, $address_id)
    {
        if (!is_numeric($store_id)) {
            $store = Store::where('slug', $store_id)->first();
            $store_id = $store->id;
        }

        $result = Address::where('id', $address_id)
            ->where('store_id', $store_id)
            ->where('user_id', Auth::id())
            ->delete();

        if ($result) {
            return jsonSuccess(200);
        }
        return jsonFailure(404, 'Not found');
    }
}
