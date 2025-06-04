<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Setting;
use Faker\Generator as Faker;

$factory->define(Setting::class, function (Faker $faker) {
    return [
        'option' => $faker->word, // e.g., 'razorpay_key', 'admin_commission'
        'value' => $faker->word,  // e.g., 'test_key', '10'
        // Add other necessary fields if the Setting model has them
    ];
});
