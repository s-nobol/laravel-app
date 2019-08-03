<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     
    public function run()
    {
        DB::table('categories')->insert([
            [ 'name' => 'スポーツ',  ],
            [ 'name' => 'ファッション',  ],
            [ 'name' => '食事・料理', ],
            [ 'name' => 'ペット・動物', ],
            [ 'name' => '恋愛・デート', ],
            [ 'name' => '日常',],
            [ 'name' => '趣味', ],
            [ 'name' => '旅行', ],
            [ 'name' => '風景', ],
            [ 'name' => '自然',],
            [ 'name' => '花・植物', ],
            [ 'name' => '未分類',  ],
        ]);
    }
}





