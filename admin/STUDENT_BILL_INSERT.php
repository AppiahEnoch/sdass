<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$response = [];

if (!isset($_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'Please login to continue';
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user_id'];
$term = $_SESSION['current_term'];
$student_class_id = $_POST['student_class_id'];
$item_id = $_POST['item_id'];
$bill_amount = $_POST['bill_amount'];
$bill_description = null;// Assuming bill_description is sent from the frontend

$stmt = $conn->prepare("INSERT INTO class_bill (user_id, term, student_class_id, bill_description, bill_amount, item_id) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE bill_amount = ?, term = ?, user_id = ?, bill_description = ?");
$stmt->bind_param("isssdiisss", $user_id, $term, $student_class_id, $bill_description, $bill_amount, $item_id, $bill_amount, $term, $user_id, $bill_description);

if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Bill added or updated successfully';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to add or update bill';
}

$stmt->close();

echo json_encode($response);
?>
