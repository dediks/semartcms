<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'slug' => $faker->slug,
        'project_id' => 3,
        'image' => "/images/1593863585.jpg",
    ];
});
