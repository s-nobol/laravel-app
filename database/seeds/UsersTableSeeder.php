<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // ログインユーザー
      
        
        // 10のユーザーとPost作成
        factory(App\User::class, 50)->create()->each(function ($user) {
                $user->posts()->save(factory(App\Post::class)->make());
                $user->comments()->save(factory(App\Comment::class)->make());
        });
    }
}
