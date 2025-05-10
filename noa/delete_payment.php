<?php
include('connection.php');

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$by = isset($_POST['by']) ? trim($_POST['by']) : '';

if ($id > 0 && !empty($by)) {
    $query = "DELETE FROM ppv_purchases WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Payment record deleted successfully by ' . $by]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete payment record']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid transaction ID or missing user']);
}

$conn->close();
?>
