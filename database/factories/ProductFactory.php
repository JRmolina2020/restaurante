<?php

use Faker\Generator as Faker;
use App\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price'=>'12000',
        'description' => $faker->sentence(8),
        'image' => 'https://e.rpp-noticias.io/normal/2019/05/14/513851_789110.jpg',
        'is_active'=>rand(1,0),
        'categorie_id' => rand(1, 9),
    ];
});
