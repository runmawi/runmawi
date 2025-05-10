<?php


include ('connection.php');

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


    
    $created_now = (new DateTime())->format('Y-m-d H:i:s');
    $updated_now = (new DateTime())->format('Y-m-d H:i:s');

   $to_time_48_hours = (new DateTime())->modify('+48 hours')->format('Y-m-d h:i:s a');


  
    $user_id = "196861"; // keimah noa - 8131883976 id
    $video_id = "97"; //Tst Movie
    $to_time = $to_time_48_hours;
    $total_amount = "200";
    $admin_commssion = "100";
    $moderator_commssion = "100";
    $status = "captured";
    $created_at = $created_now; 
    $updated_at = $updated_now;
    $moderator_id = "62";

    $payment_gateway = "manual_pay";
    $platform = "Android";
    $ppv_plan = "480p";
    $payment_id = "manual_pay_by_suport";

    
    
    

    // Insert query
   $sql = "INSERT INTO ppv_purchases (user_id, video_id, to_time, total_amount, admin_commssion, moderator_commssion, status, created_at, updated_at, moderator_id, payment_gateway, platform, ppv_plan, payment_id)
        VALUES ('$user_id', '$video_id', '$to_time', '$total_amount', '$admin_commssion', '$moderator_commssion', '$status', '$created_at', '$updated_at', '$moderator_id', '$payment_gateway', '$platform', '$ppv_plan', '$payment_id')";

    // Execute query and check for errors
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


$conn->close();






?>