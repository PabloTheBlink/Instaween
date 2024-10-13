<?php

use App\Utils\DB;

class CreateUserPostTable
{
    public function up()
    {
        DB::schema()->create('user_post', function ($table) {
            $table->string('user_post_uuid')->primary();
            $table->string('user_uuid');
            $table->longText('image');
            $table->text('caption');
            $table->timestamps();

            $table->index('user_uuid');

            $table->foreign('user_uuid')->references('user_uuid')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        DB::schema()->dropIfExists('user_post');
    }
}
