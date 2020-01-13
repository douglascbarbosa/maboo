<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'author' => $faker->name,
        'pages' => rand( 10, 1000 ),        
        'marker' => rand( 10, 10000 ),
        'user_id' => App\User::all()->random()->id
    ];
});
