<?php

namespace App\Jobs;

use App\Models\Migration;
use App\Utils\Job;

/**
 * Job to apply all pending migrations.
 */
class ApplyMigrations extends Job
{
    /**
     * Run the job.
     *
     * @return array
     */
    public function run()
    {
        // Apply all pending migrations
        return Migration::applyMigrations();
    }
}
