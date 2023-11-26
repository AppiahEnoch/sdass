<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$response = [];

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM student_payment WHERE id = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()) {
  $response['status'] = 'success';
  $response['message'] = 'Payment deleted successfully';
} else {
  $response['status'] = 'error';
  $response['message'] = 'Failed to delete payment';
}

$stmt->close();

echo json_encode($response);
?>
