<?php

$webhookUrl = 'https://dd0b-2405-201-ac0a-68e0-1e6-82ed-61c5-5240.ngrok-free.app/api/razorpay/webhook';
$webhookSecret = 'wCtnZMJu@MiHg33';

// Sample payment.failed event payload
$payload = [
    'event' => 'payment.failed',
    'payload' => [
        'payment' => [
            'entity' => [
                'id' => 'pay_test_failed_' . time(),
                'amount' => 50000, // 500.00 in paisa
                'currency' => 'INR',
                'status' => 'failed',
                'order_id' => 'order_test_' . time(),
                'method' => 'card',
                'description' => 'Test Failed Payment',
                'error_code' => 'BAD_REQUEST_ERROR',
                'error_description' => 'Payment failed due to authentication failure',
                'created_at' => time()
            ]
        ]
    ]
];

$jsonPayload = json_encode($payload);

// Generate webhook signature
$signature = hash_hmac('sha256', $jsonPayload, $webhookSecret);

// Setup cURL
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Razorpay-Signature: ' . $signature
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Response Code: " . $httpCode . "\n";
echo "Response Body: " . $response . "\n";
