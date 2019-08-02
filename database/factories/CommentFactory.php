<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'post_id' => rand(1, 5), //1~5のランダムな数字
        'content' => $faker->realText(50)
    ];
});
