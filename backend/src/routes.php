<?php

use App\Controllers\AuthController;
use App\Controllers\CloudinaryController;
use App\Controllers\PostController;
use Slim\App;

/**
 * Define the routes for the application
 *
 * @param App $app The Slim Framework application
 */
return function (App $app) {

    $app->group("/auth", function ($app) {

        /**
         * Get current user route
         */
        $app->get("/current-user", AuthController::class . ":getCurrentUser");

    });

    $app->group("/post", function ($app) {

        $app->get("/feed", PostController::class . ":getFeed");
        $app->get("/post/{post_uuid}", PostController::class . ":getPost");

        $app->get("/slide", PostController::class . ":getSlide");
        $app->post("/slide", PostController::class . ":nextSlide");

        $app->post("/save", PostController::class . ":savePost");

    });

    $app->group("/cloudinary", function ($app) {

        $app->post("/upload", CloudinaryController::class . ":uploadImage");

    });

};
