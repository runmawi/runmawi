<?php

// Test webhook endpoint accessibility
$webhookUrl = 'https://runmawi.com/api/razorpay/webhook';

echo "Testing webhook endpoint accessibility...\n";
echo "URL: $webhookUrl\n\n";

// Test with cURL
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['test' => 'connectivity']));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Razorpay-Signature: test_signature'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Response Code: $httpCode\n";
echo "cURL Error: " . ($error ?: 'None') . "\n";
echo "Response: $response\n\n";

// Test with file_get_contents
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json' . "\r\n" .
                   'X-Razorpay-Signature: test_signature',
        'content' => json_encode(['test' => 'connectivity']),
        'timeout' => 10
    ]
]);

echo "Testing with file_get_contents...\n";
$response2 = @file_get_contents($webhookUrl, false, $context);
echo "Response: " . ($response2 ?: 'Failed') . "\n";

// Show expected vs actual
echo "\n=== EXPECTED BEHAVIOR ===\n";
echo "1. HTTP Code: 400 (Invalid signature)\n";
echo "2. Or any response indicating the endpoint is reachable\n";
echo "3. Logs should show '=== RAZORPAY WEBHOOK ENTRY POINT ===' in production\n";

echo "\n=== TROUBLESHOOTING GUIDE ===\n";
echo "If HTTP Code is:\n";
echo "- 404: Route not found - check route configuration\n";
echo "- 500: Server error - check Laravel logs\n";
echo "- 0 or timeout: Network/firewall issue\n";
echo "- 403: SSL/domain access issue\n";
echo "- 400: Good! Endpoint is reachable (signature validation failed as expected)\n";

?> 