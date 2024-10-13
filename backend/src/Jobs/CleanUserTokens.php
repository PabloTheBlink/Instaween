<?php

namespace App\Jobs;

use App\Models\UserToken;
use App\Utils\DB;
use App\Utils\Job;

/**
 * Job to clean all user tokens older than DAYS_TO_KEEP_USER_TOKENS.
 */
class CleanUserTokens extends Job
{
    // Define days to keep user tokens
    const DAYS_TO_KEEP_USER_TOKENS = 1;
    /**
     * Run the job.
     *
     * @return array
     */
    public function run()
    {
        // Get all user tokens older than DAYS_TO_KEEP_USER_TOKENS days 
        $tokens = UserToken::where('created_at', '<', DB::raw('NOW() - INTERVAL ' . self::DAYS_TO_KEEP_USER_TOKENS . ' DAY'))->get();
        // Remove all user tokens older than DAYS_TO_KEEP_USER_TOKENS days
        UserToken::where('created_at', '<', DB::raw('NOW() - INTERVAL ' . self::DAYS_TO_KEEP_USER_TOKENS . ' DAY'))->delete();
        // Return the user tokens    
        return $tokens->toArray();
    }
}
