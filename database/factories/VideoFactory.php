<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Video;
use App\User; // For user_id
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Video::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'user_id' => factory(User::class)->create()->id, // Or a specific user ID if needed
        'ppv_price' => $faker->randomFloat(2, 5, 50),
        'access' => 'ppv', // Default access type
        'duration' => $faker->numberBetween(600, 7200), // Example duration in seconds
        'type' => 'mp4', // Example video type
        'status' => 1, // Example status
        'slug' => Str::slug($faker->sentence),
        // Add other necessary fields for the Video model
    ];
});
