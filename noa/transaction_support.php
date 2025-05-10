<?php


header("Content-Type: application/json");
include('connection.php');

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$support_id = isset($_POST['support_id']) ? trim($_POST['support_id']) : '';

//$support_id="noa";



$sql = "SELECT * FROM ppv_purchases WHERE update_by = ? ORDER BY updated_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $support_id);
$stmt->execute();
$result = $stmt->get_result();


$response = array();
if ($result->num_rows > 0) {
    // Fetch specific fields into the response array
    while ($row = $result->fetch_assoc()) {
        $video_id = $row['video_id'];
        
        // Query to fetch the video title from the videos table
        $videoQuery = "SELECT * FROM videos WHERE id = $video_id LIMIT 1";
        $videoResult = $conn->query($videoQuery);
        
        $title = "Unknown"; // Default title if video is not found
        if ($videoResult->num_rows > 0) {
            $videoRow = $videoResult->fetch_assoc();
            $title = $videoRow['title'];
            $image=$videoRow['image'];
        
        $imglink="https://runmawi.com/public/uploads/images/$image";
        }
        
        $id= $row['id'];
        $ppv_plan= $row['ppv_plan'];
        $total_amount=$row['total_amount'];
        $status= $row['status'];
        $update_by= $row['update_by'];
        $payment_id= $row['payment_id'];
        $updated_at = $row['updated_at'];
        $formatted_date = date("j F Y, g:i a", strtotime($updated_at)); 
        
        $user_id= $row['user_id'];
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $resultx = $stmt->get_result();
        
         if ($resultx->num_rows > 0) {
        $rowx = $resultx->fetch_assoc();
        
        $username= $rowx['username'];
        $usermobile= $rowx['mobile'];
        
         }


       $update="user";
        if($update_by!=null){
            $update="Updated by $update_by";
        }
        
        $response[] = array(
            'id' => $id,
            'total_amount' => "$ppv_plan | Rs $total_amount",
            'updated_at' => $formatted_date,
            'payment_id' => $payment_id,
             'status' => $status,
             "imglink" => $imglink,
             'update_by' => $update,
            'video_title' => "👤 $username ( $usermobile ) || $title"
        );
    }
} else {
    $response["message"] = "No data found for $support_id";
}

// Return JSON response
echo json_encode($response);

$conn->close();
?>
