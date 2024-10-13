<?php

namespace App\Jobs;

use App\Utils\Job;
use App\Models\Migration;

/**
 * Job to undo all migrations.
 */
class UndoMigrations extends Job
{
    /**
     * Run the job.
     *
     * @return void
     */
    public function run()
    {
        // Undo all migrations
        return Migration::undoMigrations();
    }
}
