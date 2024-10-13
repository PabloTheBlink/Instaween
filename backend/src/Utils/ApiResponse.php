<?php

namespace App\Utils;

use App\Config\Constants;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response as SlimResponse;

/**
 * Class ApiResponse
 * This class contains methods to handle API responses.
 *
 * @package App\Utils
 */
class ApiResponse
{
    /**
     * Send a JSON response with a 200 status code.
     *
     * @param mixed $data The data to be sent in the response.
     *
     * @return Response The response object with the data and 200 status code.
     */
    public static function ok($data = null)
    {
        ob_clean();
        $response = new SlimResponse();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Send a JSON response with a 400 status code.
     *
     * @param mixed $data The data to be sent in the response.
     * @param int $errorCode The error code.
     *
     * @return Response The response object with the data and error code.
     */
    public static function ko($data = null, $errorCode = 400)
    {
        ob_clean();
        $response = new SlimResponse();
        if ($_ENV["ENVIRONMENT"] === Constants::DEVELOPMENT) {
            $response->getBody()->write(json_encode($data));
        }
        return $response->withStatus($errorCode)->withHeader('Content-Type', 'application/json');
    }
}
