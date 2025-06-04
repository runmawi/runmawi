<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\VideoCommission;
use App\User; // For user_id
use Faker\Generator as Faker;

$factory->define(VideoCommission::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create(['role' => 'moderator'])->id, // Or a specific user ID
        'percentage' => $faker->numberBetween(5, 50), // Example commission percentage
        // Add other necessary fields if the VideoCommission model has them
    ];
});
