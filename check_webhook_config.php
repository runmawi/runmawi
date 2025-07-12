<?php
// Check current Razorpay webhook configuration
require_once 'bootstrap/app.php';

use App\PaymentSetting;
use Illuminate\Support\Facades\DB;

echo "=== Razorpay Webhook Configuration Check ===\n\n";

// Check payment settings
$paymentSetting = PaymentSetting::where('payment_type', 'Razorpay')->first();

if (!$paymentSetting) {
    echo "❌ ERROR: No Razorpay payment setting found in database\n";
    exit(1);
}

echo "✅ Payment Setting Found:\n";
echo "- ID: {$paymentSetting->id}\n";
echo "- Status: " . ($paymentSetting->status ? 'Enabled' : 'Disabled') . "\n";
echo "- Live Mode: " . ($paymentSetting->live_mode ? 'Yes' : 'No') . "\n\n";

// Check keys being used
if ($paymentSetting->live_mode) {
    echo "🔑 Using LIVE keys:\n";
    echo "- Live Publishable Key: " . ($paymentSetting->live_publishable_key ? 'SET (' . substr($paymentSetting->live_publishable_key, 0, 10) . '...)' : 'NOT SET') . "\n";
    echo "- Live Secret Key: " . ($paymentSetting->live_secret_key ? 'SET (' . substr($paymentSetting->live_secret_key, 0, 10) . '...)' : 'NOT SET') . "\n";
} else {
    echo "🧪 Using TEST keys:\n";
    echo "- Test Publishable Key: " . ($paymentSetting->test_publishable_key ? 'SET (' . substr($paymentSetting->test_publishable_key, 0, 10) . '...)' : 'NOT SET') . "\n";
    echo "- Test Secret Key: " . ($paymentSetting->test_secret_key ? 'SET (' . substr($paymentSetting->test_secret_key, 0, 10) . '...)' : 'NOT SET') . "\n";
}

echo "\n🔐 Webhook Secret Configuration:\n";
echo "- Database webhook_secret: " . ($paymentSetting->webhook_secret ? 'SET (' . strlen($paymentSetting->webhook_secret) . ' chars)' : 'NOT SET') . "\n";

// Check if .env fallback exists
$envWebhookSecret = env('RAZORPAY_WEBHOOK_SECRET');
echo "- .env RAZORPAY_WEBHOOK_SECRET: " . ($envWebhookSecret ? 'SET (' . strlen($envWebhookSecret) . ' chars)' : 'NOT SET') . "\n";

// Show effective webhook secret
$effectiveSecret = $paymentSetting->webhook_secret ?? $envWebhookSecret;
echo "- Effective webhook secret: " . ($effectiveSecret ? 'SET (' . strlen($effectiveSecret) . ' chars)' : 'NOT SET') . "\n\n";

if (!$effectiveSecret) {
    echo "❌ CRITICAL ISSUE: No webhook secret configured!\n";
    echo "   This will cause all webhook signature verifications to fail.\n\n";
} else {
    echo "✅ Webhook secret is configured\n\n";
}

// Check recent webhook events
echo "📊 Recent webhook events (last 24 hours):\n";
$recentWebhooks = DB::table('payment_webhook')
    ->where('created_at', '>=', now()->subDay())
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

if ($recentWebhooks->count() > 0) {
    foreach ($recentWebhooks as $webhook) {
        echo "- {$webhook->created_at}: {$webhook->event_type} - {$webhook->status}\n";
    }
} else {
    echo "❌ No webhook events received in the last 24 hours\n";
}

echo "\n=== Configuration Summary ===\n";
echo "Environment: " . ($paymentSetting->live_mode ? 'LIVE' : 'TEST') . "\n";
echo "Webhook Secret: " . ($effectiveSecret ? 'CONFIGURED' : 'MISSING') . "\n";
echo "Recent Webhooks: " . $recentWebhooks->count() . " in last 24h\n";

if (!$effectiveSecret) {
    echo "\n🔧 TO FIX:\n";
    echo "1. Get webhook secret from Razorpay dashboard\n";
    echo "2. Update payment_settings table or .env file\n";
    echo "3. Ensure webhook URL is configured in Razorpay dashboard\n";
}

echo "\n=== End Check ===\n"; 