<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ModeratorsUser;
use App\User; // For user_id
use Faker\Generator as Faker;

$factory->define(ModeratorsUser::class, function (Faker $faker) {
    // Create a user to associate with this moderator entry, or use an existing one
    $user = factory(User::class)->create(['role' => 'moderator']);
    return [
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'status' => 1, // Default status, e.g., active
        // Add other necessary fields if the ModeratorsUser model has them
    ];
});
