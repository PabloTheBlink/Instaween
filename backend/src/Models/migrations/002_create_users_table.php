<?php

use App\Models\User;
use App\Utils\DB;
use App\Utils\UUID;

class CreateUserTable
{
    public function up()
    {
        DB::schema()->create('user', function ($table) {
            $table->string('user_uuid')->primary();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::schema()->dropIfExists('user');
    }
}
