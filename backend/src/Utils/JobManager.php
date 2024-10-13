<?php

namespace App\Utils;

use Dotenv\Dotenv;

/**
 * Class JobManager
 *
 * This class is responsible for managing and running the jobs.
 *
 * @package App\Utils
 */
class JobManager
{
    /**
     * @var array The list of jobs
     */
    private $jobs = [];

    /**
     * JobManager constructor.
     *
     * @param string $env_uri The path to the .env file
     */
    public function __construct(string $env_uri)
    {
        // Load the environment variables from the .env file
        $dotenv = Dotenv::createImmutable($env_uri);
        $dotenv->load();
        // Set the error reporting level
        error_reporting($_ENV["ERROR_REPORTING"]);
        // Require the DB.php file to load the database
        require_once __DIR__ . '/DB.php';
    }

    /**
     * Add a job to the manager
     *
     * @param $job The job to add
     */
    public function add($job)
    {
        // Store the job in the list of jobs
        $this->jobs[class_basename($job)] = $job;
    }

    /**
     * Run all the jobs
     *
     * @param array $arguments The arguments passed to the job
     */
    public function run(array $arguments)
    {
        // Get the job name from the arguments
        $job_name = $arguments[1] ?? null;
        // Get the arguments for the job
        $args = array_slice($arguments, 2);

        // Check if the job exists
        if (!$job_name || !isset($this->jobs[$job_name])) {
            // If the job does not exist, return
            return;
        }

        // Run the job
        try {
            // Run the job and get the result
            $result = $this->jobs[$job_name]->run(...$args);
            // Return the result as JSON
            echo json_encode([
                "status" => true,
                "result" => $result
            ]);
        } catch (\Exception $e) {
            // If an exception occurs return the error as JSON
            echo json_encode([
                "status" => false,
                "exception" => $e->getMessage()
            ]);
        }
    }
}
