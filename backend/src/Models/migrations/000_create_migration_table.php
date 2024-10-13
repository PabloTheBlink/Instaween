<?php

use APP\Utils\DB;

class CreateMigrationTable
{

    public function up()
    {
        DB::schema()->create('migration', function ($table) {
            $table->id();
            $table->string('migration');
            $table->integer('batch');
            $table->timestamps();
        });
    }

    public function down() {}
}
