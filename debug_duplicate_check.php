<?php
// Debug script to test duplicate checking logic
echo "=== DEBUGGING DUPLICATE CHECK LOGIC ===\n";

// Test data - same as what Android sends
$data = [
    'user_id' => '201673',
    'video_id' => '39',
    'live_id' => null,
    'audio_id' => null,
    'series_id' => null,
    'season_id' => null,
    'py_id' => 'debug_test_' . time(),
    'py_status' => 'captured',
    'payment_type' => 'razorpay',
    'ppv_plan' => '480p',
    'amount' => '100',
    'platform' => 'Android'
];

echo "Test Data:\n";
print_r($data);

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
    
    echo "\n=== DATABASE CONNECTION ===\n";
    echo "Connecting to database: $dbHost/$dbName as $dbUser\n";
    
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection successful!\n";
    
    // Test the EXACT query that's causing the problem
    echo "\n=== TESTING CURRENT DUPLICATE CHECK LOGIC ===\n";
    
    // This is the problematic query from the code
    $sql = "SELECT * FROM ppv_purchases 
            WHERE user_id = ? 
            AND status = 'captured' 
            AND to_time > NOW() 
            AND (
                video_id = ? 
                OR live_id = ? 
                OR audio_id = ? 
                OR (series_id = ? AND season_id = ?)
            )";
    
    echo "SQL Query:\n$sql\n";
    echo "Parameters: user_id={$data['user_id']}, video_id={$data['video_id']}, live_id=" . ($data['live_id'] ?? 'NULL') . ", audio_id=" . ($data['audio_id'] ?? 'NULL') . ", series_id=" . ($data['series_id'] ?? 'NULL') . ", season_id=" . ($data['season_id'] ?? 'NULL') . "\n";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['user_id'],
        $data['video_id'],
        $data['live_id'],
        $data['audio_id'],
        $data['series_id'],
        $data['season_id']
    ]);
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Results found: " . count($results) . "\n";
    if (!empty($results)) {
        echo "FOUND MATCHING RECORDS:\n";
        foreach ($results as $result) {
            echo "ID: {$result['id']}, User: {$result['user_id']}, Video: {$result['video_id']}, Live: {$result['live_id']}, Audio: {$result['audio_id']}, Series: {$result['series_id']}, Season: {$result['season_id']}, Status: {$result['status']}, Expires: {$result['to_time']}\n";
        }
    } else {
        echo "No matching records found.\n";
    }
    
    // Test a corrected query
    echo "\n=== TESTING CORRECTED DUPLICATE CHECK LOGIC ===\n";
    
    $correctedSql = "SELECT * FROM ppv_purchases 
                     WHERE user_id = ? 
                     AND status = 'captured' 
                     AND to_time > NOW() 
                     AND video_id = ?";
    
    echo "Corrected SQL Query:\n$correctedSql\n";
    echo "Parameters: user_id={$data['user_id']}, video_id={$data['video_id']}\n";
    
    $stmt = $pdo->prepare($correctedSql);
    $stmt->execute([
        $data['user_id'],
        $data['video_id']
    ]);
    
    $correctedResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Corrected Results found: " . count($correctedResults) . "\n";
    if (!empty($correctedResults)) {
        echo "FOUND MATCHING RECORDS:\n";
        foreach ($correctedResults as $result) {
            echo "ID: {$result['id']}, User: {$result['user_id']}, Video: {$result['video_id']}, Status: {$result['status']}, Expires: {$result['to_time']}\n";
        }
    } else {
        echo "No matching records found with corrected query.\n";
    }
    
    // Check all purchases for this user to see what might be matching
    echo "\n=== ALL ACTIVE PURCHASES FOR USER ===\n";
    $allSql = "SELECT * FROM ppv_purchases 
               WHERE user_id = ? 
               AND status = 'captured' 
               AND to_time > NOW()";
    
    $stmt = $pdo->prepare($allSql);
    $stmt->execute([$data['user_id']]);
    $allResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "All active purchases for user {$data['user_id']}: " . count($allResults) . "\n";
    if (!empty($allResults)) {
        foreach ($allResults as $result) {
            echo "ID: {$result['id']}, Video: {$result['video_id']}, Live: {$result['live_id']}, Audio: {$result['audio_id']}, Series: {$result['series_id']}, Season: {$result['season_id']}, Status: {$result['status']}, Expires: {$result['to_time']}\n";
        }
    } else {
        echo "No active purchases found for this user.\n";
    }
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
} catch (Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}

echo "\n=== DONE ===\n";
?> 