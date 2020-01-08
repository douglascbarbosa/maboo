<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'title' => $faker->text($maxNbChars = 100),
        'author' => $faker->name,
        'pages' => 1,
        'marker' => 1,
        'user_id' => 1
    ];
});
