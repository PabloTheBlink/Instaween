<?php

use App\Utils\DB;

class CreateCronsTable
{
    public function up()
    {
        DB::schema()->create('cron', function ($table) {
            $table->string('name')->primary();
            $table->boolean('active')->default(0);
            $table->dateTime('last_execution_time')->nullable();
            $table->integer('repeat_after_seconds')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::schema()->dropIfExists('cron');
    }
}
