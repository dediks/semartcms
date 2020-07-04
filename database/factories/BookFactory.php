<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'cover' => $faker->imageUrl($width = 640, $height = 480),
        'price' => $faker->randomNumber(2),
        'slug' => $faker->slug,
        'author' => $faker->name,
        'description' => $faker->text,
        'publisher' => $faker->name,
        'views' => $faker->randomNumber,
        'stock' => 10,
        'project_id' => 3,
    ];
});
