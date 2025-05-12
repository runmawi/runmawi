<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\PaymentSetting;

// Get keys from .env
$test_key = env('RAZORPAY_KEY');
$test_secret = env('RAZORPAY_SECRET');
$webhook_secret = env('RAZORPAY_WEBHOOK_SECRET');

if (empty($test_key) || empty($test_secret) || empty($webhook_secret)) {
    echo "Error: One or more Razorpay keys not found in .env file\n";
    echo "Required keys:\n";
    echo "RAZORPAY_KEY: " . ($test_key ?: "Not set") . "\n";
    echo "RAZORPAY_SECRET: " . ($test_secret ? "[Set]" : "Not set") . "\n";
    echo "RAZORPAY_WEBHOOK_SECRET: " . ($webhook_secret ?: "Not set") . "\n";
    exit(1);
}

$setting = PaymentSetting::where('payment_type', 'Razorpay')->first();

if (!$setting) {
    echo "Error: Razorpay payment setting not found in database\n";
    exit(1);
}

// Store current values for comparison
$old_test_key = $setting->test_publishable_key;
$old_test_secret = $setting->test_secret_key;
$old_webhook_secret = $setting->webhook_secret;

// Update the settings
$setting->test_publishable_key = $test_key;
$setting->test_secret_key = $test_secret;
$setting->webhook_secret = $webhook_secret;
$setting->live_mode = 0; // Switch to test mode
$setting->save();

echo "Successfully updated Razorpay settings.\n\n";
echo "Configuration Changes:\n";
echo "---------------------\n";
echo "Test Mode: Enabled\n";
echo "Test Publishable Key:\n";
echo "  Old: " . ($old_test_key ?: "Not set") . "\n";
echo "  New: " . $test_key . "\n\n";
echo "Test Secret Key:\n";
echo "  Old: " . ($old_test_secret ? "[Set]" : "Not set") . "\n";
echo "  New: [Set]\n\n";
echo "Webhook Secret:\n";
echo "  Old: " . ($old_webhook_secret ?: "Not set") . "\n";
echo "  New: " . $webhook_secret . "\n";
