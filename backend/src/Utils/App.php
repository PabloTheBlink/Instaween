<?php

namespace App\Utils;

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

/**
 * Class App
 *
 * This class is used to create a new Slim app instance.
 * It sets up the environment variables, error reporting
 * and runs the app.
 */
class App
{
    /**
     * @var \Slim\App The Slim app instance
     */
    private $app;

    /**
     * App constructor.
     *
     * @param string $env_uri The path to the .env file
     */
    public function __construct(string $env_uri)
    {
        // This is for IIS
        if (!isset($_SERVER['REQUEST_URI'])) {
            if (isset($_SERVER['HTTP_X_ORIGINAL_URL'])) {
                $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
            } else {
                $_SERVER['REQUEST_URI'] = "/";
            }
        }

        // Set CORS headers
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : "*";
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json");

        // Handle OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 200 OK');
            header('Allow: GET, POST, PUT, DELETE');
            exit();
        }

        // Load environment variables
        $dotenv = Dotenv::createImmutable($env_uri);
        $dotenv->load();

        // Set error reporting
        error_reporting($_ENV["ERROR_REPORTING"]);

        // Load the DB
        require_once __DIR__ . '/DB.php';

        // Create a new Slim app instance
        $this->app = AppFactory::create();
    }

    /**
     * Set the base path for the app
     *
     * @param string $base_path The base path
     */
    public function setBasePath(string $base_path)
    {
        $this->app->setBasePath($base_path);
    }

    /**
     * Create a new router and run it
     *
     * @param string $routes_url The path to the routes file
     */
    public function createRouter(string $routes_url)
    {
        $this->app->addRoutingMiddleware();
        (require_once $routes_url)($this->app);
    }

    /**
     * Run the app
     */
    public function run()
    {
        $this->app->run();
    }
}
