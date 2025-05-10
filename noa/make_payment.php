<?php


include ('connection.php');

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $check_video_id = isset($_POST['video_id']) ? $_POST['video_id'] : '';
    $check_user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $check_ppv_plan = isset($_POST['ppv_plan']) ? $_POST['ppv_plan'] : '';
    $pay_by = isset($_POST['pay_by']) ? $_POST['pay_by'] : '';

    

    $stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->bind_param("s", $check_video_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        
        $commission_percentage = $row['CPP_commission_percentage'];
        $producer_id = $row['user_id'];
        
        
        if($check_ppv_plan=="480p"){
        $total_amount_from_db= $row['ppv_price_480p'];
        
      
        $producer_share = ceil(($commission_percentage / 100) * $total_amount_from_db);
        $admin_share=$total_amount_from_db-$producer_share;
        
        }
        if($check_ppv_plan=="720p"){
        $total_amount_from_db= $row['ppv_price_720p'];
        
        $producer_share = ceil(($commission_percentage / 100) * $total_amount_from_db);
        $admin_share=$total_amount_from_db-$producer_share;
        
        }


       if($check_ppv_plan=="1080p"){
        $total_amount_from_db= $row['ppv_price_1080p'];
        $producer_share = ceil(($commission_percentage / 100) * $total_amount_from_db);
        $admin_share=$total_amount_from_db-$producer_share;
        
        
        }
        
        

    
    $created_now = (new DateTime())->format('Y-m-d H:i:s');
    $updated_now = (new DateTime())->format('Y-m-d H:i:s');

   

   $to_time_72_hours = (new DateTime())->modify('+72 hours')->format('Y-m-d h:i:s a');


  
    $user_id = $check_user_id; 
    $video_id = $check_video_id; 
    $to_time = $to_time_72_hours;
    $total_amount = $total_amount_from_db;
    $admin_commssion = $admin_share;
    $moderator_commssion = $producer_share;
    $status = "captured";
    $created_at = $created_now; 
    $updated_at = $updated_now;
    $moderator_id = $producer_id;

    $payment_gateway = "manual_pay_by_$pay_by";
    $platform = "Android";
    $ppv_plan = $check_ppv_plan;
    $payment_id = "manual_pay_by_$pay_by";

    
    
    

    // Insert query
   $sql = "INSERT INTO ppv_purchases (user_id, video_id, to_time, total_amount, admin_commssion, moderator_commssion, status, created_at, updated_at, moderator_id, payment_gateway, platform, ppv_plan, payment_id, update_by)
        VALUES ('$user_id', '$video_id', '$to_time', '$total_amount', '$admin_commssion', '$moderator_commssion', '$status', '$created_at', '$updated_at', '$moderator_id', '$payment_gateway', '$platform', '$ppv_plan', '$payment_id', '$pay_by')";

    // Execute query and check for errors
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Payment  successfully']);
    } else {
        echo json_encode(['success' => true, 'message' => 'Payment fail']);
    }
    
    }


$conn->close();






?>