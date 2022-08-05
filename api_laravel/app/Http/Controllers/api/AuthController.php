<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
     /**
* Get a JWT via given credentials.
*
* @return \Illuminate\Http\JsonResponse
*/
public function login(Request $request)
{
    $credentials = $request->only(['email', 'password']);
    if (! $token = auth()->guard('api')->attempt($credentials)) {
    return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->respondWithToken($token);
}


/**
* Get the token array structure.
*
* @param string $token
*
* @return \Illuminate\Http\JsonResponse
*/
protected function respondWithToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
    ]);
}



/**
* Log the user out (Invalidate the token).
*
* @return \Illuminate\Http\JsonResponse
*/
public function logout()
{
    auth()->guard('api')->logout();
    return response()->json(['message' => 'Successfully logged out']);
}


}
