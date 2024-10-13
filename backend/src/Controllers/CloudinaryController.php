<?php

namespace App\Controllers;

use App\Providers\CloudinaryProvider;
use App\Utils\ApiResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class CloudinaryController
 * @package App\Controllers
 */
class CloudinaryController
{

    public function uploadImage(Request $request): Response
    {

        $body = json_decode($request->getBody()->getContents());

        $public_id = CloudinaryProvider::uploadImage($body->image);

        return ApiResponse::ok([
            "public_id" => $public_id
        ]);
    }

}
