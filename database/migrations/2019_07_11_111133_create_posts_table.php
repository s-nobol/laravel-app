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
     *  $table->bigIncrements('id');
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            // $table->string('id')->primary();  //普通のIDに戻す 
            $table->bigIncrements('id'); 
            $table->string('token');  //トークンの追加
            $table->unsignedInteger('user_id'); 
            $table->unsignedInteger('category_id'); 
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable(); //ファイル名（ファイルパス）
            $table->timestamps();
            
            // $table->foreign('user_id')->references('id')->on('users');
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
