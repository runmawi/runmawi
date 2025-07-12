<?php
// Quick webhook timing check
try {
    $pdo = new PDO("mysql:host=localhost;dbname=runmawi", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🕐 QUICK WEBHOOK TIMING CHECK\n";
    echo "==============================\n\n";
    
    // Recent payments analysis
    $stmt = $pdo->prepare("
        SELECT 
            order_id,
            status,
            created_at,
            CASE 
                WHEN created_at >= '2025-07-12 19:16:00' THEN 'AFTER_ISSUE'
                WHEN created_at >= '2025-07-12 04:03:00' THEN 'BEFORE_ISSUE'
                ELSE 'MUCH_EARLIER'
            END as time_category
        FROM ppv_purchases 
        WHERE created_at >= '2025-07-12 00:00:00'
        ORDER BY created_at DESC
        LIMIT 10
    ");
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $before_issue = 0;
    $after_issue = 0;
    
    foreach ($payments as $payment) {
        $emoji = $payment['time_category'] === 'AFTER_ISSUE' ? '🔴' : 
                ($payment['time_category'] === 'BEFORE_ISSUE' ? '🟡' : '🟢');
        
        echo "{$emoji} {$payment['order_id']} - {$payment['status']} - {$payment['created_at']}\n";
        
        if ($payment['time_category'] === 'AFTER_ISSUE') $after_issue++;
        elseif ($payment['time_category'] === 'BEFORE_ISSUE') $before_issue++;
    }
    
    echo "\n📊 SUMMARY:\n";
    echo "🟢 Before issue (working): {$before_issue}\n";
    echo "🔴 After issue (broken): {$after_issue}\n";
    
    // Check latest webhook
    $stmt = $pdo->prepare("
        SELECT created_at, event, status 
        FROM razorpay_webhook_logs 
        ORDER BY created_at DESC 
        LIMIT 1
    ");
    $stmt->execute();
    $latest_webhook = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($latest_webhook) {
        echo "\n🔄 Latest webhook: {$latest_webhook['created_at']}\n";
        echo "   Event: {$latest_webhook['event']}\n";
        echo "   Status: {$latest_webhook['status']}\n";
    } else {
        echo "\n❌ No webhooks found\n";
    }
    
    echo "\n⚡ QUICK DIAGNOSIS:\n";
    if ($after_issue > 0) {
        echo "🚨 CONFIRMED: {$after_issue} payments after 19:16 are stuck as pending\n";
        echo "   → Webhook delivery is broken\n";
        echo "   → Check Razorpay dashboard immediately\n";
    } else {
        echo "✅ No recent payments found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?> 