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
use App\Category;
use App\User;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    
    return [
        /*'user_id' => $faker->randElement(User::pluck('id')->toArray()),*/
        'user_id' => function()
        {
            return factory(App\User::class)->create()->id;
        },
        'user_type' => function (array $category) {
            return App\User::find($category['user_id'])->type;
        },
        'category_name' => $faker->category_name,
        'category_status' => $faker->category_status,
        'description' => $faker->description,
    ];
});