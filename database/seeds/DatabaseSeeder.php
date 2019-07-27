<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AdminSeeder::class);
    }
}

// php artisan make:seed AdminSeeder
// php artisan make:seed UsersTableSeeder
//UsersTableSeeder.php
//   public function run()
//     {
//         //
//         factory(App\User::class, 10)->create()->each(function ($user) {
//                 $user->posts()->save(factory(App\Post::class)->make());
//                 $user->comments()->save(factory(App\Comment::class)->make());
//         });
//     }