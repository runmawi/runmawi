<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\PaymentSetting;
use Illuminate\Support\Facades\DB;

echo "🔍 WEBHOOK ISSUE DIAGNOSTIC TOOL\n";
echo "=================================\n\n";

// 1. Check PaymentSetting Configuration
echo "1️⃣  PAYMENT SETTINGS ANALYSIS\n";
echo "==============================\n";

$paymentSetting = PaymentSetting::where('payment_type', 'Razorpay')->first();

if (!$paymentSetting) {
    echo "❌ CRITICAL: No Razorpay payment setting found\n";
    exit(1);
}

echo "✅ Payment Setting Found (ID: {$paymentSetting->id})\n\n";

// Check current mode and keys
echo "📊 Current Configuration:\n";
echo "--------------------------\n";
echo "Live Mode: " . ($paymentSetting->live_mode ? "ENABLED" : "DISABLED") . "\n";
echo "Status: " . ($paymentSetting->status ? "ENABLED" : "DISABLED") . "\n\n";

// Check which keys are being used
if ($paymentSetting->live_mode == 0) {
    echo "🧪 USING TEST KEYS:\n";
    echo "Test Publishable Key: " . ($paymentSetting->test_publishable_key ? "[SET]" : "[NOT SET]") . "\n";
    echo "Test Secret Key: " . ($paymentSetting->test_secret_key ? "[SET]" : "[NOT SET]") . "\n";
    $current_key_id = $paymentSetting->test_publishable_key;
    $current_secret = $paymentSetting->test_secret_key;
} else {
    echo "🏭 USING LIVE KEYS:\n";
    echo "Live Publishable Key: " . ($paymentSetting->live_publishable_key ? "[SET]" : "[NOT SET]") . "\n";
    echo "Live Secret Key: " . ($paymentSetting->live_secret_key ? "[SET]" : "[NOT SET]") . "\n";
    $current_key_id = $paymentSetting->live_publishable_key;
    $current_secret = $paymentSetting->live_secret_key;
}

// Check webhook secret
echo "\n🔐 WEBHOOK SECRET CONFIGURATION:\n";
echo "---------------------------------\n";
$webhook_secret_db = $paymentSetting->webhook_secret;
$webhook_secret_env = env('RAZORPAY_WEBHOOK_SECRET');

echo "Database webhook_secret: " . ($webhook_secret_db ? "[SET - " . strlen($webhook_secret_db) . " chars]" : "[NOT SET]") . "\n";
echo "Environment RAZORPAY_WEBHOOK_SECRET: " . ($webhook_secret_env ? "[SET - " . strlen($webhook_secret_env) . " chars]" : "[NOT SET]") . "\n";

$effective_webhook_secret = $webhook_secret_db ?? $webhook_secret_env;
echo "Effective webhook secret: " . ($effective_webhook_secret ? "[SET - " . strlen($effective_webhook_secret) . " chars]" : "[NOT SET]") . "\n\n";

if (!$effective_webhook_secret) {
    echo "❌ CRITICAL: No webhook secret configured!\n";
    echo "   Razorpay webhooks require a secret for signature verification.\n";
    echo "   Configure it in Razorpay dashboard and update your settings.\n\n";
}

// 2. Check Recent Orders from Android
echo "2️⃣  RECENT ANDROID PAYMENT ANALYSIS\n";
echo "=====================================\n";

$recentOrders = DB::table('ppv_purchases')
    ->where('platform', 'Android')
    ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-7 days')))
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

if ($recentOrders->count() > 0) {
    echo "✅ Found {$recentOrders->count()} recent Android payments:\n\n";
    
    foreach ($recentOrders as $order) {
        echo "Payment ID: {$order->payment_id}\n";
        echo "User ID: {$order->user_id}\n";
        echo "Video ID: " . ($order->video_id ?? 'N/A') . "\n";
        echo "Amount: ₹{$order->total_amount}\n";
        echo "Status: {$order->status}\n";
        echo "Created: {$order->created_at}\n";
        echo "Updated: {$order->updated_at}\n";
        
        // Check if webhook was received
        $webhookRecord = DB::table('payment_webhook')
            ->where('order_id', $order->payment_id)
            ->orWhere('payment_id', $order->payment_id)
            ->first();
        
        if ($webhookRecord) {
            echo "✅ Webhook: RECEIVED ({$webhookRecord->event_type})\n";
        } else {
            echo "❌ Webhook: NOT RECEIVED\n";
        }
        
        // Check timing
        $createdTime = strtotime($order->created_at);
        $updatedTime = strtotime($order->updated_at);
        $timeDiff = $updatedTime - $createdTime;
        
        echo "⏱️  Update Delay: {$timeDiff} seconds";
        if ($timeDiff < 10) {
            echo " (Manual confirmation likely)";
        } elseif ($timeDiff > 30) {
            echo " (Webhook processing likely)";
        }
        echo "\n\n" . str_repeat("-", 50) . "\n\n";
    }
} else {
    echo "⚠️  No recent Android payments found\n\n";
}

// 3. Check Webhook Activity
echo "3️⃣  WEBHOOK ACTIVITY ANALYSIS\n";
echo "===============================\n";

$recentWebhooks = DB::table('payment_webhook')
    ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-7 days')))
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

if ($recentWebhooks->count() > 0) {
    echo "✅ Found {$recentWebhooks->count()} recent webhooks:\n\n";
    
    foreach ($recentWebhooks as $webhook) {
        echo "Order ID: {$webhook->order_id}\n";
        echo "Payment ID: {$webhook->payment_id}\n";
        echo "Event: {$webhook->event_type}\n";
        echo "Amount: ₹{$webhook->amount}\n";
        echo "Status: {$webhook->status}\n";
        echo "Created: {$webhook->created_at}\n\n";
    }
} else {
    echo "❌ NO WEBHOOKS RECEIVED IN LAST 7 DAYS\n";
    echo "   This is the smoking gun - webhooks are not being delivered at all.\n\n";
}

// 4. Test Webhook Configuration
echo "4️⃣  WEBHOOK CONFIGURATION TEST\n";
echo "================================\n";

// Test webhook endpoint
echo "Testing webhook endpoint accessibility...\n";
$webhookUrl = 'https://runmawi.com/api/razorpay/webhook';

$testPayload = json_encode(['test' => 'connectivity']);
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $testPayload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Razorpay-Signature: test_signature'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Webhook URL: $webhookUrl\n";
echo "HTTP Response: $httpCode\n";

if ($httpCode == 400) {
    echo "✅ Endpoint accessible (signature validation failed as expected)\n\n";
} else {
    echo "❌ Endpoint issue - HTTP $httpCode\n";
    echo "Response: $response\n\n";
}

// 5. Diagnosis Summary
echo "5️⃣  DIAGNOSIS SUMMARY\n";
echo "======================\n\n";

$issues = [];
$recommendations = [];

// Check for issues
if (!$effective_webhook_secret) {
    $issues[] = "❌ No webhook secret configured";
    $recommendations[] = "Configure webhook secret in Razorpay dashboard and update payment settings";
}

if ($recentWebhooks->count() == 0) {
    $issues[] = "❌ No webhooks received in last 7 days";
    $recommendations[] = "Check Razorpay dashboard webhook configuration and delivery status";
}

if ($httpCode != 400) {
    $issues[] = "❌ Webhook endpoint not accessible";
    $recommendations[] = "Check server configuration and firewall settings";
}

// Check for key environment mismatch
$androidUsingTest = $paymentSetting->live_mode == 0;
echo "🔧 CONFIGURATION ANALYSIS:\n";
echo "---------------------------\n";
echo "Android payments using: " . ($androidUsingTest ? "TEST" : "LIVE") . " keys\n";
echo "Webhook verification using: " . ($androidUsingTest ? "TEST" : "LIVE") . " mode\n";

if (substr($current_key_id ?? '', 0, 8) === 'rzp_test') {
    echo "Key type detected: TEST keys\n";
} elseif (substr($current_key_id ?? '', 0, 8) === 'rzp_live') {
    echo "Key type detected: LIVE keys\n";
} else {
    echo "⚠️  Could not detect key type\n";
    $issues[] = "❌ Invalid or missing API keys";
    $recommendations[] = "Verify Razorpay API keys are correctly configured";
}

echo "\n";

// Summary
if (empty($issues)) {
    echo "✅ No critical issues detected\n";
    echo "🔧 Possible causes:\n";
    echo "   - Webhook events not enabled in Razorpay dashboard\n";
    echo "   - Webhook URL not configured in Razorpay dashboard\n";
    echo "   - Network/firewall blocking Razorpay webhook delivery\n";
} else {
    echo "🚨 CRITICAL ISSUES FOUND:\n";
    foreach ($issues as $issue) {
        echo "   $issue\n";
    }
    echo "\n🔧 RECOMMENDATIONS:\n";
    foreach ($recommendations as $rec) {
        echo "   • $rec\n";
    }
}

echo "\n📋 NEXT STEPS:\n";
echo "===============\n";
echo "1. Check Razorpay dashboard webhook configuration\n";
echo "2. Verify webhook URL: https://runmawi.com/api/razorpay/webhook\n";
echo "3. Ensure payment.captured event is enabled\n";
echo "4. Verify webhook secret matches between dashboard and database\n";
echo "5. Check webhook delivery logs in Razorpay dashboard\n";
echo "6. Test with a small payment while monitoring logs\n";

?> 