<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // ログインユーザー
        DB::table('users')->insert([
            'name' => '123',
            'email' => '123@example.com',
            'password' => bcrypt('123123123'),
            'role' => 3 ,//ユーザーにレベル3の権限
        ]);
      
    }
}
