<?php
// Direct test of payment functionality
echo "=== DIRECT TEST OF ADD_PAYPERVIEW ===\n";

// Bootstrap Laravel
require_once 'bootstrap/app.php';

use Illuminate\Http\Request;
use App\Http\Controllers\ApiAuthController;
use Illuminate\Support\Facades\Log;

// Create a mock request
$requestData = [
    'user_id' => '201673',
    'video_id' => '39',
    'py_id' => 'direct_test_' . time(),
    'py_status' => 'captured',
    'payment_type' => 'razorpay',
    'ppv_plan' => '480p',
    'amount' => '100',
    'platform' => 'Android'
];

echo "Request data:\n";
print_r($requestData);

try {
    // Create request object
    $request = Request::create('/api/auth/add_payperview', 'POST', $requestData);
    
    $controller = new ApiAuthController();
    $response = $controller->add_payperview($request);
    
    echo "\n=== RESPONSE ===\n";
    echo "Status Code: " . $response->getStatusCode() . "\n";
    echo "Response Body: " . $response->getContent() . "\n";
    
    // Check database after the call
    echo "\n=== CHECKING DATABASE AFTER CALL ===\n";
    $pdo = new PDO(
        "mysql:host=" . env('DB_HOST') . ";dbname=" . env('DB_DATABASE'), 
        env('DB_USERNAME'), 
        env('DB_PASSWORD')
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("SELECT * FROM ppv_purchases WHERE user_id = ? AND video_id = ? ORDER BY created_at DESC LIMIT 3");
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
    
} catch (Exception $e) {
    echo "\n=== ERROR ===\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== DONE ===\n";
?> 