<?php
// Debug script to test add_payperview endpoint
echo "=== TESTING ADD_PAYPERVIEW ENDPOINT ===\n";

$testData = [
    'user_id' => '201673',
    'video_id' => '39',
    'py_id' => 'test_debug_' . time(),
    'py_status' => 'captured',
    'payment_type' => 'razorpay',
    'ppv_plan' => '480p',
    'amount' => '100',
    'platform' => 'Android'
];

echo "Test Data:\n";
print_r($testData);

// Make a POST request to the endpoint
$url = 'http://localhost/api/auth/add_payperview';
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($testData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'Accept: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

curl_close($ch);

echo "\n=== RESPONSE ===\n";
echo "HTTP Code: $httpCode\n";
echo "Response: $response\n";
if ($error) {
    echo "cURL Error: $error\n";
}

// Also check the database directly
echo "\n=== CHECKING DATABASE ===\n";
try {
    // Get database config from Laravel
    $config = include 'config/database.php';
    $dbConfig = $config['connections']['mysql'];
    
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']}", 
        $dbConfig['username'], 
        $dbConfig['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if the purchase was created
    $stmt = $pdo->prepare("SELECT * FROM ppv_purchases WHERE user_id = ? AND video_id = ? ORDER BY created_at DESC LIMIT 5");
    $stmt->execute(['201673', '39']);
    $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Recent purchases for user 201673, video 39:\n";
    if (empty($purchases)) {
        echo "No purchases found!\n";
    } else {
        foreach ($purchases as $purchase) {
            echo "ID: {$purchase['id']}, Payment ID: {$purchase['payment_id']}, Status: {$purchase['status']}, Created: {$purchase['created_at']}\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
}

echo "\n=== DONE ===\n";
?> 