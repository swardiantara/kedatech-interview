<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "code" => 400,
                    "status" => "fail",
                    "message" => $validator->errors(),
                    "data" => [
                        "email" => $request->email,
                    ]
                ], 400);
            }

            $credentials = $request->only(['email', 'password']);
            
            $user = User::where('email', $request->email)->where('deleted_at', NULL)->first();
            
            if(!$user) {
                return response()->json([
                    "code" => 404,
                    "status" => "fail",
                    "message" => "User not found",
                ], 404);
            }
            
            $token = auth()->attempt($credentials);
            if(!$token) {
                return response()->json([
                    "code" => 401,
                    "status" => "fail",
                    "message" => "Invalid email/password",
                    "data" => [
                        "email" => $request->email,
                    ]
                ], 401);
            }

            $formatted = $this->formatToken($token);
            return response()->json([
                "code" => 200,
                "status" => "success",
                "message" => "login successful",
                "data" => $formatted,
            ], 200);

        } catch (\Throwable $th) {
            abort(
                response()->json([
                    "code" => 500,
                    "status" => "error",
                    "message" => "Internal Server Error"
                ], 500)
            );
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json([
            "code" => 200,
            'message' => 'User successfully signed out'
        ]);
    }

    protected function formatToken($token){
        return array(
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        );
    }
}
