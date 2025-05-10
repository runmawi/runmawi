<?php

header("Content-Type: application/json");
include('connection.php');

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Query to fetch all columns
$sql = "SELECT * FROM videos WHERE video_category_id = 0 AND access = 'ppv' ORDER BY created_at DESC";

$result = $conn->query($sql);

$response = array();
if ($result->num_rows > 0) {
    // Fetch specific fields into the response array
    while ($row = $result->fetch_assoc()) {
        $video_id = $row['video_id'];
        
        
        
        $id= $row['id'];
        $title= $row['title'];
        $ppv_price_480p=$row['ppv_price_480p'];
        $ppv_price_720p=$row['ppv_price_720p'];
        $ppv_price_1080p=$row['ppv_price_1080p'];
        
        $image=$row['image'];
        
        $imglink="https://runmawi.com/public/uploads/images/$image";
        
        
        $response[] = array(
            'id' => $id,
            'title' => $title,
            "imglink" => $imglink,
            'ppv_price_480p' => $ppv_price_480p,
            'ppv_price_720p' => $ppv_price_720p,
            'ppv_price_1080p' => $ppv_price_1080p
            
        );
    }
} else {
    $response["message"] = "No record found.";
}

// Return JSON response
echo json_encode($response);

$conn->close();
?>
