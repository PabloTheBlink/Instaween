<?php

namespace App\Providers;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryProvider
{

    public static function uploadImage($image_b64)
    {

        set_time_limit(0);

        Configuration::instance("cloudinary://{$_ENV['CLOUDINARY_API_KEY']}:{$_ENV['CLOUDINARY_API_SECRET']}@{$_ENV['CLOUDINARY_CLOUD_NAME']}?secure=true");

        $uploadApi = new UploadApi();
        $response = $uploadApi->upload($image_b64, [
            'folder' => 'instaween'
        ]);

        $publicId = $response['public_id'];

        return $publicId;

    }

}