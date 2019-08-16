<?php

use Faker\Generator as Faker;
use App\Categorie;

$factory->define(Categorie::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'is_active'=>rand(1,0)
    ];
});
