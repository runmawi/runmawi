<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\PaymentSetting;

$setting = PaymentSetting::where('payment_type', 'Razorpay')->first();

if (!$setting) {
    echo "Error: Razorpay payment setting not found\n";
    exit(1);
}

// Store current values
$currentMode = $setting->live_mode;
$test_key = $setting->test_publishable_key;
$test_secret = $setting->test_secret_key;

// Switch to test mode
$setting->live_mode = 0;
$setting->save();

echo "Successfully switched to test mode.\n\n";
echo "Current Configuration:\n";
echo "-------------------\n";
echo "Mode: " . ($setting->live_mode == 0 ? "Test" : "Live") . "\n";
echo "Test Publishable Key: " . ($test_key ?: "Not set") . "\n";
echo "Test Secret Key: " . ($test_secret ? "Set" : "Not set") . "\n";

if (!$test_key || !$test_secret) {
    echo "\nWARNING: Test keys are not configured. Please set them in the database or admin panel.\n";
}
