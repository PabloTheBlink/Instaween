<?php

use App\Utils\DB;

class CreateUserPostTable
{
    public function up()
    {
        DB::schema()->create('user_post_like', function ($table) {
            $table->string('user_post_uuid');
            $table->string('user_uuid');
            $table->boolean('opt');
            $table->timestamps();

            $table->primary(['user_post_uuid', 'user_uuid']);

            $table->foreign('user_post_uuid')->references('user_post_uuid')->on('user_post')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_uuid')->references('user_uuid')->on('user')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        DB::schema()->dropIfExists('user_post_like');
    }
}
