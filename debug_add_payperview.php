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

// Make a POST request to the endpoint - use the correct domain
$url = 'https://runmawi.com/api/auth/add_payperview';  // Use the actual domain
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($testData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'Accept: application/json',
    'User-Agent: Mozilla/5.0 (compatible; Debug Script)'
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
    // Read .env file manually
    $envFile = '.env';
    $envVars = [];
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                $envVars[trim($key)] = trim($value);
            }
        }
    }
    
    $dbHost = $envVars['DB_HOST'] ?? 'localhost';
    $dbName = $envVars['DB_DATABASE'] ?? 'runmawi';
    $dbUser = $envVars['DB_USERNAME'] ?? 'root';
    $dbPass = $envVars['DB_PASSWORD'] ?? '';
    
    echo "Connecting to database: $dbHost/$dbName as $dbUser\n";
    
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
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
            echo "ID: {$purchase['id']}, Payment ID: {$purchase['payment_id']}, Status: {$purchase['status']}, Created: {$purchase['created_at']}, Expires: {$purchase['to_time']}\n";
        }
    }
    
    // Check if any purchases are still active
    $stmt = $pdo->prepare("SELECT * FROM ppv_purchases WHERE user_id = ? AND video_id = ? AND status = 'captured' AND to_time > NOW() ORDER BY created_at DESC");
    $stmt->execute(['201673', '39']);
    $activePurchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\nActive purchases for user 201673, video 39:\n";
    if (empty($activePurchases)) {
        echo "No active purchases found!\n";
    } else {
        foreach ($activePurchases as $purchase) {
            echo "ID: {$purchase['id']}, Payment ID: {$purchase['payment_id']}, Status: {$purchase['status']}, Expires: {$purchase['to_time']}\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
}

echo "\n=== DONE ===\n";
?> 