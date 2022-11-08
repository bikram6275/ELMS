<?php

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MeResource;
use App\Models\Emitter;
use Illuminate\Support\Facades\Hash;
use App\Models\Organization\Organization;
use App\Repository\Organization\OrganizationRepository;

class AuthController extends Controller
{
    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }
    /**
     * Log in the user.
     *
     * @bodyParam   email    string  required    The email of the  user.      Example: enumerator@gmail.com
     * @bodyParam   password    string  required    The password of the  user.   Example: ymc123
     *
     * @response data:{
     * "user": {
     *      "id": 1,
     *       "name": "tr",
     *       "email": "enumerator@gmail.com",
     *       "user_status": "active",
     *       "phone_no": "9874125632",
     *      "remember_token": null,
     *      "created_at": "2021-10-20T07:02:01.000000Z",
     *      "updated_at": "2021-10-20T07:02:01.000000Z",
     *      "pradesh_id": 2,
     *      "district_id": 16,
     *      "muni_id": 156,
     *      "ward_no": 14
     *   },
     *  "token": "eyJ0eXA...",
     *  "expires_in": "2022-11-08T09:38:14.000000Z",
     * }
     */
    public function login(Request $request)
    {
        $user = Emitter::where('email', $request['email'])->with('pradesh:id,pradesh_name','district:id,english_name')->first();
        if (!empty($user) && (Hash::check($request['password'], $user->password))) {
            $success['user'] = $user;
            $token = $user->createToken('authToken');
            $success['token'] = $token->accessToken;
            $success['expires_in'] = $token->token->expires_at;
            return response()->json(['data' => $success], 200);
        } else {
            return response()->json(['message' => 'Invalid email or password'], 422);
        }
    }
    public function getUser()
    {
        try {
            $user = auth()->guard('api')->user();
            return response()->json(['data' => new MeResource($user)], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        $id = (int) auth()->guard('api')->user()->id;
        try {
            $organization = $this->organizationRepository->findById($id);

            if ($organization) {
                $value = $request->all();
                $value['password'] = bcrypt($request->password);
                $organization->fill($value)->save();

                return response()->json(['message' => 'User Updated Successfully'], 200);
            } else {
                return response()->json(['message' => 'No record with given id!'], 422);
            }
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }
}
