<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$response = [];

$admission_number = $_POST['admission_number'];

$stmt = $conn->prepare("DELETE FROM student WHERE admission_number = ?");
$stmt->bind_param("s", $admission_number);

if ($stmt->execute()) {
  $response['status'] = 'success';
  $response['message'] = 'Student record deleted successfully';
} else {
  $response['status'] = 'error';
  $response['message'] = 'Failed to delete student record';
}

$stmt->close();

echo json_encode($response);
?>
