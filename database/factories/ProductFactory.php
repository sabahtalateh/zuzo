<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $categories = \App\Models\Category::pluck('id')->toArray();

    return [
        'name' => implode(' ', $faker->words(2)),
        'details' => $faker->text,
        'image' => $faker->imageUrl(250, 400, 'technics'),
        'category_id' => $faker->randomElement($categories)
    ];
});
