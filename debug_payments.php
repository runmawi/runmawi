<?php

/**
 * Debug script to verify payment system functionality
 * 
 * Usage: php debug_payments.php [user_id]
 * Example: php debug_payments.php 201673
 */

require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Get user ID from command line argument
$user_id = $argv[1] ?? '201673';

echo "🔍 Payment System Debug Report\n";
echo "==============================\n";
echo "User ID: $user_id\n";
echo "Timestamp: " . now() . "\n\n";

try {
    // 1. Check recent PPV purchases
    echo "📺 Recent PPV Purchases (Last 10):\n";
    echo "==================================\n";
    
    $recentPurchases = DB::table('ppv_purchases')
        ->where('user_id', $user_id)
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();

    if ($recentPurchases->isEmpty()) {
        echo "❌ No PPV purchases found for user $user_id\n";
    } else {
        foreach ($recentPurchases as $purchase) {
            $contentId = $purchase->video_id ?? $purchase->live_id ?? $purchase->audio_id ?? 'N/A';
            $contentType = $purchase->video_id ? 'Video' : ($purchase->live_id ? 'Live' : ($purchase->audio_id ? 'Audio' : 'Unknown'));
            
            echo sprintf(
                "🎬 %s ID: %s | Plan: %s | Amount: ₹%s | Status: %s | Gateway: %s | Created: %s\n",
                $contentType,
                $contentId,
                $purchase->ppv_plan ?? 'N/A',
                $purchase->total_amount ?? 'N/A',
                $purchase->status ?? 'N/A',
                $purchase->payment_gateway ?? 'N/A',
                $purchase->created_at ?? 'N/A'
            );
        }
    }

    // 2. Check active PPV purchases (not expired)
    echo "\n📅 Active PPV Purchases (Not Expired):\n";
    echo "=====================================\n";
    
    $activePurchases = DB::table('ppv_purchases')
        ->where('user_id', $user_id)
        ->where('to_time', '>', now())
        ->where('status', 'captured')
        ->orderBy('created_at', 'desc')
        ->get();

    if ($activePurchases->isEmpty()) {
        echo "❌ No active PPV purchases found\n";
    } else {
        echo "✅ Found " . $activePurchases->count() . " active purchases:\n";
        foreach ($activePurchases as $purchase) {
            $contentId = $purchase->video_id ?? $purchase->live_id ?? $purchase->audio_id ?? 'N/A';
            $contentType = $purchase->video_id ? 'Video' : ($purchase->live_id ? 'Live' : ($purchase->audio_id ? 'Audio' : 'Unknown'));
            
            echo sprintf(
                "✅ %s ID: %s | Expires: %s | Plan: %s\n",
                $contentType,
                $contentId,
                $purchase->to_time,
                $purchase->ppv_plan ?? 'N/A'
            );
        }
    }

    // 3. Check recent payment webhooks
    echo "\n🔗 Recent Payment Webhooks (Last 5):\n";
    echo "====================================\n";
    
    $recentWebhooks = DB::table('payment_webhook')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    if ($recentWebhooks->isEmpty()) {
        echo "❌ No payment webhook records found\n";
    } else {
        foreach ($recentWebhooks as $webhook) {
            echo sprintf(
                "🔔 %s | Order: %s | Payment: %s | Amount: ₹%s | Status: %s | %s\n",
                $webhook->event_type ?? 'N/A',
                substr($webhook->order_id ?? 'N/A', -10), // Last 10 chars
                substr($webhook->payment_id ?? 'N/A', -10), // Last 10 chars
                $webhook->amount ?? 'N/A',
                $webhook->status ?? 'N/A',
                $webhook->created_at ?? 'N/A'
            );
        }
    }

    // 4. Test API endpoint response
    echo "\n🧪 API Endpoint Test:\n";
    echo "====================\n";
    
    $testUrl = "https://runmawi.com/api/auth/add_payperview";
    $testData = [
        'user_id' => 'TEST_USER',
        'video_id' => '999',
        'py_id' => 'test_' . time(),
        'py_status' => 'captured',
        'payment_type' => 'razorpay',
        'ppv_plan' => '480p',
        'amount' => '1',
        'platform' => 'debug_test'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $testUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($testData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($response === false) {
        echo "❌ API test failed - Could not connect\n";
    } else {
        echo "📡 HTTP Status: $httpCode\n";
        $responseData = json_decode($response, true);
        
        if ($responseData) {
            echo "📄 Response: " . json_encode($responseData, JSON_PRETTY_PRINT) . "\n";
            
            if (isset($responseData['message'])) {
                if (strpos($responseData['message'], 'Purchase completed successfully') !== false) {
                    echo "✅ API returning CORRECT response format (immediate processing)\n";
                } elseif (strpos($responseData['message'], 'Payment confirmation received') !== false) {
                    echo "❌ API returning OLD response format (webhook-only processing)\n";
                } else {
                    echo "⚠️ API returning unexpected response format\n";
                }
            }
        } else {
            echo "❌ Invalid JSON response: $response\n";
        }
    }

    // 5. Check Laravel log for recent payment activity
    echo "\n📝 Recent Payment Logs:\n";
    echo "======================\n";
    
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $logContent = shell_exec("tail -20 $logFile | grep -i 'ADD PAYPERVIEW\\|payment\\|razorpay'");
        if ($logContent) {
            echo $logContent;
        } else {
            echo "No recent payment-related logs found\n";
        }
    } else {
        echo "❌ Laravel log file not found\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n✅ Debug report completed!\n";
echo "\n💡 Tips:\n";
echo "- If API returns old format, run deployment script again\n";
echo "- Monitor logs during payment testing: tail -f storage/logs/laravel.log\n";
echo "- Check webhook processing if payments succeed but no DB entry\n"; 