<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('post_type')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->text('excerpt')->nullable();
            $table->string('comment_status')->nullable();
            $table->string('password')->nullable();
            $table->string('slug')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
