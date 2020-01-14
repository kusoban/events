<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Event;
use App\User;
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

$factory->define(Event::class, function (Faker $faker) {
    $user = User::all()->random();
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'starts_at' => $faker->dateTimeThisMonth(),
        'image' => $faker->randomElement(['1.png', '2.jpg', '3.jpg']),
        'creator_id' => $user->id,
        'creator_email' => $user->email
    ];
});
