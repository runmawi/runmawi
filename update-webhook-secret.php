<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\PaymentSetting;

$webhookSecret = env('RAZORPAY_WEBHOOK_SECRET');

if (empty($webhookSecret)) {
    echo "Error: RAZORPAY_WEBHOOK_SECRET not found in .env file\n";
    exit(1);
}

$paymentSetting = PaymentSetting::where('payment_type', 'Razorpay')->first();

if (!$paymentSetting) {
    echo "Error: No Razorpay payment setting found\n";
    exit(1);
}

$paymentSetting->webhook_secret = $webhookSecret;
$paymentSetting->save();

echo "Successfully updated webhook_secret in payment_settings table\n";
