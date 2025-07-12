<?php
// Simple test to check database directly
echo "=== SIMPLE DATABASE TEST ===\n";

// Test data
$testData = [
    'user_id' => '201673',
    'video_id' => '39',
    'py_id' => 'simple_test_' . time(),
    'py_status' => 'captured',
    'payment_type' => 'razorpay',
    'ppv_plan' => '480p',
    'amount' => '100',
    'platform' => 'Android'
];

echo "Test Data:\n";
print_r($testData);

try {
    // Read .env file manually
    $envFile = '.env';
    $envVars = [];
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && !str_starts_with($line, '#')) {
                list($key, $value) = explode('=', $line, 2);
                $envVars[trim($key)] = trim($value);
            }
        }
    }
    
    $dbHost = $envVars['DB_HOST'] ?? 'localhost';
    $dbName = $envVars['DB_DATABASE'] ?? 'runmawi';
    $dbUser = $envVars['DB_USERNAME'] ?? 'root';
    $dbPass = $envVars['DB_PASSWORD'] ?? '';
    
    echo "\n=== DATABASE CONNECTION ===\n";
    echo "Connecting to database: $dbHost/$dbName as $dbUser\n";
    
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection successful!\n";
    
    // Check existing purchases first
    echo "\n=== CHECKING EXISTING PURCHASES ===\n";
    $stmt = $pdo->prepare("SELECT * FROM ppv_purchases WHERE user_id = ? AND video_id = ? ORDER BY created_at DESC LIMIT 5");
    $stmt->execute(['201673', '39']);
    $existingPurchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Existing purchases for user 201673, video 39:\n";
    if (empty($existingPurchases)) {
        echo "No existing purchases found!\n";
    } else {
        foreach ($existingPurchases as $purchase) {
            echo "ID: {$purchase['id']}, Payment ID: {$purchase['payment_id']}, Status: {$purchase['status']}, Created: {$purchase['created_at']}\n";
        }
    }
    
    // Now try to insert a test purchase directly
    echo "\n=== INSERTING TEST PURCHASE ===\n";
    
    // Get PPV expiry time
    $ppv_hours = 24;
    $from_time = date('Y-m-d h:i:s a');
    $to_time = date('Y-m-d h:i:s a', strtotime('+' . $ppv_hours . ' hour'));
    
    $insertData = [
        'user_id' => $testData['user_id'],
        'video_id' => $testData['video_id'],
        'from_time' => $from_time,
        'to_time' => $to_time,
        'ppv_plan' => $testData['ppv_plan'],
        'total_amount' => $testData['amount'],
        'payment_gateway' => $testData['payment_type'],
        'payment_id' => $testData['py_id'],
        'status' => $testData['py_status'],
        'platform' => $testData['platform'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    echo "Attempting to insert:\n";
    print_r($insertData);
    
    $insertSql = "INSERT INTO ppv_purchases (user_id, video_id, from_time, to_time, ppv_plan, total_amount, payment_gateway, payment_id, status, platform, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($insertSql);
    $result = $stmt->execute([
        $insertData['user_id'],
        $insertData['video_id'],
        $insertData['from_time'],
        $insertData['to_time'],
        $insertData['ppv_plan'],
        $insertData['total_amount'],
        $insertData['payment_gateway'],
        $insertData['payment_id'],
        $insertData['status'],
        $insertData['platform'],
        $insertData['created_at'],
        $insertData['updated_at']
    ]);
    
    if ($result) {
        $insertId = $pdo->lastInsertId();
        echo "✅ SUCCESS! Purchase inserted with ID: $insertId\n";
    } else {
        echo "❌ FAILED to insert purchase\n";
    }
    
    // Check if the purchase was created
    echo "\n=== VERIFYING INSERT ===\n";
    $stmt = $pdo->prepare("SELECT * FROM ppv_purchases WHERE user_id = ? AND video_id = ? ORDER BY created_at DESC LIMIT 3");
    $stmt->execute(['201673', '39']);
    $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "All purchases for user 201673, video 39 after insert:\n";
    if (empty($purchases)) {
        echo "No purchases found!\n";
    } else {
        foreach ($purchases as $purchase) {
            echo "ID: {$purchase['id']}, Payment ID: {$purchase['payment_id']}, Status: {$purchase['status']}, Created: {$purchase['created_at']}\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
} catch (Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}

echo "\n=== DONE ===\n";
?> 