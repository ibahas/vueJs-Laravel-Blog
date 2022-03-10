<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $title = $faker->sentence(rand(2,4));
    return [
        'name' => $title,
        'slug' => Str::slug($title)
    ];
});
