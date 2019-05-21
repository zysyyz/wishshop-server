<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(App\Models\Brand::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});


$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->name,
    ];
});


$factory->define(App\Models\Store::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->name,
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});
