<?php

use App\Utils\DB;

class CreateUserTokenTable
{
    public function up()
    {
        DB::schema()->create('user_token', function ($table) {
            $table->string('token')->primary();
            $table->string('user_uuid');
            $table->timestamps();

            $table->index('user_uuid');

            $table->foreign('user_uuid')->references('user_uuid')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        DB::schema()->dropIfExists('user_token');
    }
}
