<?php

require 'vendor/autoload.php';
require 'bootstrap/app.php';

use Razorpay\Api\Api;

// Test card details:
// Card Number: 4111 1111 1111 1111
// Expiry: Any future date
// CVV: Any 3 digits
// Name: Any name
// 3D Secure Password: 1234

$api = new Api('rzp_test_798bpYwl6pkvae', 'P75dOdv7oUknkCN05ZocBPsh');

// Create an order
$orderData = [
    'amount' => 50000, // ₹500 in paise
    'currency' => 'INR',
    'receipt' => 'test_receipt_' . time(),
    'notes' => [
        'video_id' => '123',
        'type' => 'video_rent'
    ]
];

try {
    $order = $api->order->create($orderData);
    echo "Order created successfully!\n";
    echo "Order ID: " . $order->id . "\n";
    echo "\nUse these test card details:\n";
    echo "Card Number: 4111 1111 1111 1111\n";
    echo "Expiry: Any future date\n";
    echo "CVV: Any 3 digits\n";
    echo "Name: Any name\n";
    echo "3D Secure Password: 1234\n";
    
    // Create payment HTML
    $html = '
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    var options = {
        "key": "rzp_test_798bpYwl6pkvae",
        "amount": "' . $orderData['amount'] . '",
        "currency": "INR",
        "name": "Test Video Rental",
        "description": "Test Payment",
        "order_id": "' . $order->id . '",
        "handler": function (response) {
            alert("Payment successful! Payment ID: " + response.razorpay_payment_id);
        },
        "prefill": {
            "name": "Test User",
            "email": "test@example.com",
            "contact": "9999999999"
        },
        "theme": {
            "color": "#F37254"
        }
    };
    var rzp1 = new Razorpay(options);
    window.onload = function() {
        rzp1.open();
    }
    </script>
    ';
    
    // Save the payment HTML
    file_put_contents('public/test-payment.html', $html);
    echo "\nPayment page created! Opening browser...\n";
    
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
