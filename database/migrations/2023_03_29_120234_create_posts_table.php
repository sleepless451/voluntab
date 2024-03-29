<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->integer('post_type');
            $table->integer('status');
            $table->text('description');
            $table->boolean('is_map');
            $table->string('map_long')->nullable()->default(NULL);
            $table->string('map_lat')->nullable()->default(NULL);
            $table->string('contact_info');
            $table->string('image_link')->nullable()->default(NULL);
            $table->timestamps();
            $table->index('id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
