<?php
include('connection.php');



$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$by = isset($_POST['by']) ? trim($_POST['by']) : ''; // Ensure 'by' is properly retrieved

 echo json_encode(['success' => false, 'message' => $by.' a Mark as Paid theih rih loh. Movie Leisak Na atang lei sak zawk rawh ']);
 
 die();

$updated_at = (new DateTime())->format('Y-m-d H:i:s');
$to_time = (new DateTime())->modify('+72 hours')->format('Y-m-d h:i:s a');
$payment_id = "mark_as_paid_by_$by";

if ($id > 0 && !empty($by)) { // Ensure 'by' is not empty
    $query = "UPDATE ppv_purchases SET status = 'captured', update_by = ?, updated_at = ?, to_time = ?, payment_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $by, $updated_at, $to_time, $payment_id, $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Payment status and timestamps updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update payment status and timestamps']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid transaction ID ']);
}

$conn->close();
?>
