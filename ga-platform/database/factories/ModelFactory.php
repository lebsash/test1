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

// GA User
$factory->define(GAPlatform\Models\GAUser::class, function (Faker\Generator $faker) {
    return [
        'UserID' => rand(1,8000),
        'Email' => $faker->email,
        'Name' => $faker->name,
        'URL' => $faker->url,
    ];
});
// GA SalesPerson
$factory->define(GAPlatform\Models\GASalesPerson::class, function (Faker\Generator $faker) {
    return [
        'SalesPersonID' => rand(1,8000),
        'Name' => $faker->name,
        'Title' => $faker->name,
        'Email' => $faker->companyEmail,
        'Office' => 'Email subject',
    ];
});
