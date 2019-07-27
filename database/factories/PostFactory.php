<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [  
        'token' => Str::random(10),
        'title' => $faker->sentence(rand(1,4)), 
        'description' => $faker->realText(100), // 512文字の文章
        'image' => null,
        
    ];
});
