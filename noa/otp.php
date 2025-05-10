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

    $stmt = $conn->prepare("SELECT otp FROM users WHERE mobile = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $otp= $row['otp'];
        
        if($otp==null){
            $otp_data="otp request tir phawt rawh";
        }else{
            $otp_data="otp chu : $otp";
        }
        
        echo json_encode(["otp" => $otp_data]);
    } else {
        echo json_encode(["error" => "He phone number hi ala in register lo"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>
