<?php
header("Content-Type: application/json");

include('connection.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $support_id = isset($_POST['support_id']) ? $_POST['support_id'] : '';
    $passcode = isset($_POST['passcode']) ? $_POST['passcode'] : '';

    if (empty($support_id) || empty($passcode)) {
        echo json_encode(["status" => "error", "message" => "Support ID and passcode are required"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM support_users WHERE support_id = ? AND passcode = ?");
    $stmt->bind_param("ss", $support_id, $passcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['name'];
        $imglink = $row['imglink'];
        
        echo json_encode([
            "status" => "success",
             "name" => $username,
             "imglink" => $imglink,
            "message" => "Welcome, " . $username
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid Support ID or passcode"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

$conn->close();
?>
