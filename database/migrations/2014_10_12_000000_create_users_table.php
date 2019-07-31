<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            
            $table->string('image')->nullable(); //ファイル名（ファイルパス）
            $table->string('message')->nullable(); //一言
            $table->string('address')->nullable(); //住所
            $table->integer('sex')->nullable(); //性別( 0: 男, 1: 女 )
            $table->date('birthday')->nullable(); //性別
            $table->string('link')->nullable(); //リンク
            $table->integer('role')->default(0); //ユーザー権限(0,1,2,3)
            
            // $table->string('toekn')->unique(); //認証トークン
            // $table->$table->boolean('activated')->default(false); //認証トークン
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
