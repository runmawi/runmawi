<?php

// Test webhook logging with enhanced logging
$webhookUrl = 'https://runmawi.com/api/razorpay/webhook';
$webhookSecret = 'wCtnZMJu@MiHg33'; // Replace with actual secret

// Sample payment.captured event payload similar to user 201673 video 39
$payload = [
    'event' => 'payment.captured',
    'payload' => [
        'payment' => [
            'entity' => [
                'id' => 'pay_test_' . time(),
                'amount' => 100, // ₹1.00 in paisa
                'currency' => 'INR',
                'status' => 'captured',
                'order_id' => 'order_test_' . time(),
                'method' => 'card',
                'description' => 'Test Payment for Video 39',
                'created_at' => time(),
                'captured_at' => time(),
                'notes' => [
                    'user_id' => '201673',
                    'video_id' => '39',
                    'order_id' => 'order_test_' . time(),
                    'platform' => 'Android'
                ]
            ]
        ]
    ]
];

$jsonPayload = json_encode($payload);

echo "🧪 Testing Enhanced Webhook Logging\n";
echo "=====================================\n";
echo "URL: $webhookUrl\n";
echo "Payload: " . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
echo "=====================================\n\n";

// Generate webhook signature (you'll need to replace with actual secret)
$signature = hash_hmac('sha256', $jsonPayload, $webhookSecret);

// Setup cURL
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Razorpay-Signature: ' . $signature,
    'User-Agent: RazorpayTestWebhook/1.0'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$startTime = microtime(true);
$response = curl_exec($ch);
$endTime = microtime(true);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

$duration = round(($endTime - $startTime) * 1000, 2);

echo "📊 Test Results:\n";
echo "================\n";
echo "HTTP Response Code: $httpCode\n";
echo "Response Time: {$duration}ms\n";
echo "cURL Error: " . ($error ?: 'None') . "\n";
echo "Response Body: $response\n\n";

echo "🔍 What to Look For in Logs:\n";
echo "=============================\n";
echo "1. Look for: '🚀 === RAZORPAY WEBHOOK ENTRY POINT === 🚀'\n";
echo "2. Look for: '💳 === PAYMENT CAPTURED HANDLER START ==='\n";
echo "3. Look for: '🎯🎯🎯 VIDEO 39 WEBHOOK DETECTED - SPECIAL LOGGING 🎯🎯🎯'\n";
echo "4. Look for: '👤👤👤 USER 201673 WEBHOOK DETECTED - SPECIAL LOGGING 👤👤👤'\n";
echo "5. Look for: '✅ Webhook processing completed successfully'\n\n";

echo "🔧 How to Check Logs:\n";
echo "======================\n";
echo "On your server, run:\n";
echo "tail -f /path/to/your/laravel.log | grep -E '🚀|💳|🎯|👤|✅|❌'\n\n";

echo "🎯 Expected Behavior:\n";
echo "=====================\n";
if ($httpCode == 200) {
    echo "✅ SUCCESS: Webhook processed successfully\n";
    echo "   - Check logs for detailed processing information\n";
} elseif ($httpCode == 400) {
    echo "⚠️ SIGNATURE ISSUE: Invalid signature (expected if using dummy secret)\n";
    echo "   - Update \$webhookSecret with real secret for full test\n";
} else {
    echo "❌ ERROR: HTTP $httpCode\n";
    echo "   - Check server logs for detailed error information\n";
}

echo "\n🔄 Next Steps:\n";
echo "===============\n";
echo "1. Update \$webhookSecret in this script with your real webhook secret\n";
echo "2. Run this script again to test with proper signature\n";
echo "3. Check your Laravel logs for the enhanced logging output\n";
echo "4. Make a real payment to see if webhooks are now being received\n";

?> 