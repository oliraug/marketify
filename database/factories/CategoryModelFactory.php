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
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Category::class, function (Faker\Generator $faker) {
    
    return [
    	'user_id' => $faker->randElement(User::pluck('id')->toArray()),
        /*'user_id' => function()
        {
        	return factory(App\User::class)->create()->id;
        },*/
        'category_name' => $faker->category_name,
        'category_status' => $faker->category_status,
        'description' => $faker->description,
    ];
});
