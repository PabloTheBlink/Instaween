<?php

/**
 * This script is the entry point for the jobs.
 * It will execute all the registered jobs.
 */

use App\Jobs\ApplyMigrations;
use App\Jobs\CleanUserTokens;
use App\Jobs\UndoMigrations;
use App\Utils\JobManager;

// Require the autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Create a new instance of the JobManager
$manager = new JobManager(__DIR__ . "/../");

// Add the ApplyMigrations Job
$manager->add(new ApplyMigrations());

// Add the UndoMigrations Job
$manager->add(new UndoMigrations());

// Add the CleanUserTokens Job
$manager->add(new CleanUserTokens());

// Run all the jobs
$manager->run($argv);
