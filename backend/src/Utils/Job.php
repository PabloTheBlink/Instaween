<?php

namespace App\Utils;

/**
 * Class Job
 *
 * This class is an abstract class that all jobs should extend.
 * It provides a method to dispatch the job and run it in the background.
 * It also provides a method to get the path to the PHP executable.
 */
abstract class Job
{
    /**
     * @var string The path to the composer executable.
     */
    protected $composer;

    /**
     * @var string The path to the PHP executable.
     */
    protected $php;

    /**
     * @var string The path to the npm executable.
     */
    protected $npm;

    /**
     * Job constructor.
     */
    public function __construct()
    {
        $this->composer = Job::getServerCommandUri("phpenv", "composer");
        $this->php = Job::getServerCommandUri("phpenv", "php");
        $this->npm = Job::getServerCommandUri("nodenv", "npm");
    }

    /**
     * Get the path to the PHP executable.
     *
     * @param string $env
     * @param string $command
     * @return string
     */
    private static function getServerCommandUri($env, $command)
    {
        // If the OS is Windows, return the command directly.
        if (stripos(PHP_OS, 'WIN') === 0) {
            return $command;
        }

        // Try to find the command in the shims directory.
        $command_1 = $_SERVER['HOME'] . "/.{$env}/shims/{$command}";
        $exists_1 = !empty(shell_exec("command -v $command_1"));
        if ($exists_1) {
            return $command_1;
        }

        // Try to find the command in the system path.
        $exists_2 = !empty(shell_exec("command -v $command"));
        if ($exists_2) {
            return $command;
        }

        // If the command is not found, die with an error message.
        die("No command {$command}");
    }

    /**
     * Dispatch the job and run it in the background.
     *
     * @param mixed ...$args
     */
    public static function dispatch(...$args)
    {
        // Get the path to the job.php file.
        $baseDir = dirname(realpath($_SERVER['SCRIPT_FILENAME']));
        $normalizedPath = str_replace('\\', '/', $baseDir . "/../bin/job.php");

        // Get the class name.
        $fullClassName = get_called_class();
        $className = basename(str_replace('\\', '/', $fullClassName));

        // Get the arguments.
        $argsString = implode(' ', array_map('escapeshellarg', $args));

        // Run the job.
        if (stripos(PHP_OS, 'WIN') === 0) {
            // Windows os exec.
            $command = "start /B php " . $normalizedPath . " " . $className . " " . $argsString . " > NUL 2>&1";
            pclose(popen($command, 'r'));
        } else {
            $command = Job::getServerCommandUri("phpenv", "php") . " " . $normalizedPath . " " . $className . " " . $argsString . " > /dev/null 2>&1 &";
            shell_exec($command);
        }
    }
}
