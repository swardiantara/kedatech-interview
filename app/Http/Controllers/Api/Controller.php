<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        auth()->setDefaultDriver('api');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authUser() {
        try {
            $user = auth()->userOrFail();
            if (!$user) {
                return response()->json([
                    "code" => 404,
                    "status" => "fail",
                    "message" => "User not found"
                ], 404);
            }
            return $user;
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                "code" => 401,
                "status" => "fail",
                "message" => "Token is Expired"
            ], 401);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                "code" => 401,
                "status" => "fail",
                "message" => "Token is Invalid"
            ], 401);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                "code" => 401,
                "status" => "fail",
                "message" => "Authorization Token not found"
            ], 401);
        }
    }
    
}
