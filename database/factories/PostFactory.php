<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->sentence(rand(5, 10));
    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'body' => $faker->paragraph(rand(1,3)),
        'user_id' => Rand(1,10),
        'category_id' => Rand(1, 10),
        'photo' => $faker->randomElement(['http://localhost:8000/storage/2.svg','http://localhost:8000/storage/1.png']),
    ];
});
