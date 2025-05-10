<?php
header("Content-Type: application/json");

include('connection.php');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    if (empty($phone)) {
        echo json_encode(["error" => "Phone number is required"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE mobile = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $username= $row['username'];
        $id= $row['id'];
        $name= $row['name'];
        $mobile= $row['mobile'];
        $ccode= $row['ccode'];
        $email= $row['email'];
        $role= $row['role'];
        $otp= $row['otp'];
        $created_at= $row['created_at'];
        $updated_at= $row['updated_at'];
        $avatar=$row['avatar'];
        
        
        $formatted_date = date("d F Y", strtotime($created_at));
        
        
        
        
        $imglink="https://runmawi.com/public/uploads/avatars/$avatar";
        
        
        if($otp==null){
            $otp_data="No Active OTP";
        }else{
            $otp_data="$otp";
        }
        
        echo json_encode([
            "userid" => $id,
            "name" => $username,
            "mobile" => "$ccode $mobile",
            "email" => $email,
            "role" => $role,
            "otp" => $otp_data,
             "imglink" => $imglink,
            "created_at" => $formatted_date,
            "updated_at" => $updated_at
            
            
            ]);
    } else {
        echo json_encode(["error" => "He phone number hi ala in register lo"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>
