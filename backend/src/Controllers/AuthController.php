<?php

namespace App\Controllers;

use App\Utils\ApiResponse;
use App\Models\User;
use App\Models\UserToken;
use App\Utils\UUID;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class AuthController
 * @package App\Controllers
 */
class AuthController
{
    /**
     * Get current user
     * 
     * @param Request $request
     * @return Response
     */
    public function getCurrentUser(Request $request): Response
    {

        function createAndLoginAnonymousUser()
        {

            $user_uuid = UUID::generate();
            $user_token = UUID::generate();

            $user = User::create([
                "user_uuid" => $user_uuid
            ]);

            $user_token = UserToken::create([
                "token" => $user_token,
                "user_uuid" => $user_uuid
            ]);

            // Return the user as a JSON response
            return ApiResponse::ok([
                "user" => $user,
                "user_token" => $user_token
            ]);
        }

        // Get the bearer token from request headers
        $bearerToken = $request->getHeaderLine("Authorization");

        // Get the user with the given bearer token
        $user_token = UserToken::where("token", str_replace("Bearer ", "", $bearerToken))->first();

        // Return an error response if the user does not exist
        if (!$user_token) {
            return createAndLoginAnonymousUser();
        }

        // Get the user with the given bearer token
        $user = User::where("user_uuid", $user_token->user_uuid)->first();

        // Return an error response if the user does not exist
        if (!$user) {
            return createAndLoginAnonymousUser();
        }

        // Return the user as a JSON response
        return ApiResponse::ok([
            "user" => $user,
            "user_token" => $user_token
        ]);
    }

}
