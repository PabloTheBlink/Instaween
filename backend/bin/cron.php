<?php

/**
 * This script is the entry point for the cron jobs.
 * It will execute all the registered cron jobs.
 */

use App\Jobs\CleanUserTokens;
use App\Utils\CronManager;

// Require the autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Create a new instance of the CronManager
$manager = new CronManager(__DIR__ . "/../");

// Add the CleanUserTokens Job
$manager->add(new CleanUserTokens());

// Run all the cron jobs
$manager->run();
