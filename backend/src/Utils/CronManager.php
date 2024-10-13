<?php

namespace App\Utils;

use App\Models\Cron;
use Dotenv\Dotenv;

/**
 * Class CronManager
 *
 * This class is responsible for managing and running the crons.
 *
 * @package App\Utils
 */
class CronManager
{
    /**
     * The array of crons
     *
     * @var array
     */
    private $crons = [];

    /**
     * CronManager constructor.
     *
     * @param string $env_uri The path to the .env file
     */
    public function __construct(string $env_uri)
    {
        $dotenv = Dotenv::createImmutable($env_uri);
        $dotenv->load();
        error_reporting($_ENV["ERROR_REPORTING"]);
        require_once __DIR__ . '/DB.php';
    }

    /**
     * Add a cron to the manager
     *
     * @param $cron The cron to add
     */
    public function add($cron)
    {
        $this->crons[class_basename($cron)] = $cron;

        if (!Cron::where("name", class_basename($cron))->exists()) {
            Cron::create([
                "name" => class_basename($cron)
            ]);
        }
    }

    /**
     * Run all the crons
     */
    public function run()
    {
        $crons = Cron::where('active', 1)
            ->where(function ($query) {
                $query->whereNull('last_execution_time')
                    ->orWhereRaw('(repeat_after_seconds is not null and TIMESTAMPDIFF(SECOND, last_execution_time, NOW()) >= repeat_after_seconds)');
            })->get();

        foreach ($crons as $cron) {

            try {

                $result = $this->crons[$cron->name]->run();

                $cron->update([
                    "last_execution_time" => DB::raw("NOW()")
                ]);

                echo json_encode([
                    "status" => true,
                    "result" => $result
                ]);
            } catch (\Exception $e) {
                echo json_encode([
                    "status" => false,
                    "exception" => $e->getMessage()
                ]);
            }
        }
    }
}
