<?php

namespace App\Controllers;

use App\Models\UserPost;
use App\Models\UserPostLike;
use App\Models\UserToken;
use App\Utils\ApiResponse;
use App\Utils\UUID;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class PostController
 * @package App\Controllers
 */
class PostController
{

    public function getFeed(Request $request): Response
    {
        return ApiResponse::ok(UserPost::orderBy("created_at", "desc")->limit(10)->get());
    }

    public function getSlide(Request $request): Response
    {
        $bearerToken = $request->getHeaderLine("Authorization");
        $user_token = UserToken::where("token", str_replace("Bearer ", "", $bearerToken))->first();

        $post = UserPost::leftJoin('user_post_like', function ($join) use ($user_token) {
            $join->on('user_post.user_post_uuid', '=', 'user_post_like.user_post_uuid')
                ->where('user_post_like.user_uuid', '=', $user_token->user_uuid);
        })
            ->whereNull('user_post_like.created_at')
            ->orderBy('user_post.created_at', 'desc')
            ->select('user_post.*')
            ->first();

        return ApiResponse::ok($post);
    }

    public function nextSlide(Request $request): Response
    {
        $bearerToken = $request->getHeaderLine("Authorization");
        $user_token = UserToken::where("token", str_replace("Bearer ", "", $bearerToken))->first();

        $body = json_decode($request->getBody()->getContents());
        $opt = $body->opt;
        $user_post_uuid = $body->user_post_uuid;

        if (UserPostLike::where("user_post_uuid", $user_post_uuid)->where("user_uuid", $user_token->user_uuid)->exists()) {
            UserPostLike::where("user_post_uuid", $user_post_uuid)->where("user_uuid", $user_token->user_uuid)->update([
                "opt" => $opt
            ]);
        } else {
            UserPostLike::create([
                "user_post_uuid" => $user_post_uuid,
                "user_uuid" => $user_token->user_uuid,
                "opt" => $opt
            ]);
        }

        $post = UserPost::leftJoin('user_post_like', function ($join) use ($user_token) {
            $join->on('user_post.user_post_uuid', '=', 'user_post_like.user_post_uuid')
                ->where('user_post_like.user_uuid', '=', $user_token->user_uuid);
        })
            ->whereNull('user_post_like.created_at')
            ->orderBy('user_post.created_at', 'desc')
            ->select('user_post.*')
            ->first();

        return ApiResponse::ok($post);
    }

    public function savePost(Request $request): Response
    {

        $bearerToken = $request->getHeaderLine("Authorization");
        $user_token = UserToken::where("token", str_replace("Bearer ", "", $bearerToken))->first();

        $body = json_decode($request->getBody()->getContents());

        $post = UserPost::create([
            "user_post_uuid" => UUID::generate(),
            "user_uuid" => $user_token->user_uuid,
            "caption" => isset($body->caption) ? $body->caption : "",
            "image" => $body->image,
        ]);

        return ApiResponse::ok($post);
    }

}
